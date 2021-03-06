<?php

namespace App\Controllers;
use App\Models\EntradaModel;
use App\Models\UsuarioModel;


class Mapa extends BaseController
{
	var $model;
	var $db;
	public function __construct()
	{
		$this->db = \Config\Database::connect();
		$this->model = new EntradaModel(4);
	}
    public function index()
	{	
		$this->meta->title = "Registros en Mapa";
		$data = ['from' => 'Mapa/index/'];
		$this->addCss(array(
			'lib/leaflet/leaflet.css'
		));
		$this->addJs(array(
			'lib/leaflet/leaflet.js',
			'js/mapa/mostrar.js',
		));
		$filter = $this->request->getGet('filtro') ?? 'recientes';
        $categ_id = $this->request->getGet('categoria') ?? null;
        $filters = ['filtro' => $filter, 'categoria' => $categ_id];
        $data['filtros'] = $filters;

		$query = $this->db->query("SELECT * FROM entrada WHERE entr_tipo_id = 4");
		$results = $query->getResult();

		$locPins=[];

		foreach($results as $value){
			$locPins[] = [
				"id" => $value->entr_id,
				"lat" => $value->entr_map_lat, 
				"lng" => $value->entr_map_lng,
			];
		}
		
		//var_dump(json_encode($locPins));
		$data['categorias'] = $this->model->getCategorias();
		$data['locPins'] = json_encode($locPins);
		
		$this->showHeader();
		$this->ShowContent('index', $data);
		$this->showFooter();
	}

	public function misregistros($page = 1){
		$this->meta->title = "Mis registros";
		$data = ['from' => 'Mapa/misregistros'];
		$filters = [
            'user' => $this->user->id,
            'solo_publicos' => false,
            'fecha' => false
        ];
		helper("pagination");

		$quant_results = $this->model->countListado($filters);
        $quant_to_show = 4;
        $dataPag = setPaginationData($data, $quant_results, $quant_to_show, $page);
        
        $data += [
            'mapas' => $this->model->getDataListado($filters, $quant_to_show, $dataPag['start_from_page']),
        ];
		$this->addJs(array(
    	    'js/mapa/mapa.js'
        ));
		$this->showHeader();
		$this->ShowContent('misregistros', $data);
		$this->showFooter();
	}

	public function crear(){
		$this->meta->title = "Crear registro en mapa";
		if($permiso = $this->diePermiso($this->user->id)) return $permiso;
		helper('formulario');
		$data = [
			'id'=> 0,
			'titulo' => 'Publicar Mapa',
			'fields' => $this->model->get()
		];
		$this->addCss(array(
			'lib/leaflet/leaflet.css'
		));
		$this->addJs(array(
			'lib/leaflet/leaflet.js',
			'js/mapa/mapa.js',
			"lib/tinymce/tinymce.min.js",
			"lib/tinymce/jquery.tinymce.min.js",
			'js/entrada/publicar.js'
		));
		$this->showHeader();
		$this->ShowContent('form', $data);
		$this->showFooter();
	}

	public function guardar($id = '')
	{
		$data = $this->validar($this->model->getFields());
		unset($data['usua_foto']);

		if(empty($id)){
			$data['entr_fechareg'] = date('Y-m-d H:i:s');
			$data['entr_fechapub'] = date('Y-m-d H:i:s');
			$data['entr_tipo_id'] = $this->request->getPost('entr_tipo_id');
			$data['entr_map_lat'] = $this->request->getPost('entr_map_lat');
			$data['entr_map_lng'] = $this->request->getPost('entr_map_lng');
			$data['entr_usua_id'] = $this->user->id;
			$this->db->table('entrada')->insert($data);
			$id = $this->db->insertID();
			$path = 'img_'.$id.'.small.jpg';
			if($this->guardar_imagen('uploads/mapa', $path)){
				$this->db->table('entrada')->update(array('entr_foto'=>$path), "entr_id = '{$id}'" );
			}
		}else{
			$path = 'img_'.$id.'.small.jpg';
			if($this->guardar_imagen('uploads/mapa',$path)){
				$data = $data + array('entr_foto' => $path);
			}
			$this->db->table('entrada')->update($data,"entr_id = '{$id}'");
		}
		$this->dieMsg(true,'', base_url('/Mapa/misregistros'));
	}

	public function editar($id){
		$this->meta->title = "Editar registros en Mapa";
		if($permiso = $this->diePermiso($this->user->id)) return $permiso;
		helper('formulario');
		$this->addCss(array(
			'lib/leaflet/leaflet.css'
		));
		$this->addJs(array(
			'lib/leaflet/leaflet.js',
			'js/mapa/mapa.js',
			"lib/tinymce/tinymce.min.js",
			"lib/tinymce/jquery.tinymce.min.js",
			'js/entrada/publicar.js'
		));
		$datos['id'] = $id;
		$datos['titulo'] = 'Editar Mapa';
		$datos['fields'] = $this->model->get($id);
		$datos['fields']->entr_foto->value = base_url('uploads/mapa') . (empty($datos['fields']->entr_foto->value) ? '/sinlogo.png' : '/' . $datos['fields']->entr_foto->value);
		
		$this->showHeader();
		$this->ShowContent('form', $datos);
		$this->showFooter();
	}

	public function eliminar($id)
	{
		$builder = $this->model->getBuilder();
        $this->dieAjax();

        $this->db->table('usuario_entrada')
            ->where('rela_usua_id', $this->user->id)
            ->where('rela_entr_id', $id)
        ->delete();

        $builder
            ->where('entr_id', $id)
            ->where('entr_usua_id', $this->user->id)
        	->delete();
        $this->dieMsg();
	}
	public function setPunto($entrid, $punto)
    {
        $this->dieAjax();
        $this->diePermiso($this->user->id);

        $data = [
            'entr_id' => $entrid,
            'usua_id' => $this->user->id,
            'punto' => $punto,
        ];

        $this->model->insertPoint((object)$data);

        echo json_encode($this->model->getPoints($data['entr_id'], $data['usua_id']));
    }

	public function ver($id){
		$this->meta->title = "Ver mapa";
		helper('formulario');
        $entr = $this->model->getEntrada($id);
        $usermod = new UsuarioModel();
        $user = $usermod->getUser($entr->entr_usua_id);
        
        if ($this->model->db->affectedRows() == 0) return redirect()->to(base_url('Mapa'));
        $data = [
            'reg' => (object)((array)$entr + (array)$user),
        ];
        $this->showHeader();
        $this->ShowContent('ver', $data);
        $this->showFooter();
	}

    public function getData($id)
    {
        $this->dieAjax();
        $this->diePermiso($this->user->id);

        $entr = $this->db->query("SELECT * FROM entrada WHERE entr_id={$id}")->getRow();
        $row = $this->model->getBuilderUsuaEntr($id, $this->user->id)->select()->get()->getRow();

        $entr->rmas = $row->rela_nmas ?? 0;
        $entr->rmenos = $row->rela_nmenos ?? 0;
        
        echo json_encode($entr);
    }

}
