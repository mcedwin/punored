<?php

namespace App\Controllers;
use App\Models\MapaModel;

class Mapa extends BaseController
{
	var $model;
	public function __construct()
	{
		$this->model = new MapaModel();
	}
    public function index($rowno = 0)
	{
		$this->addCss(array(
			'lib/leaflet/leaflet.css'
		));
		$this->addJs(array(
			'lib/leaflet/leaflet.js',
			'js/mapa/mostrar.js'
		));
		$data = [
            'mapas' => $this->model->getMapaData($filters, $quant_to_show, $dataPag['start_from_page']),
        ];
		$this->showHeader();
		$this->ShowContent('index', $data);
		$this->showFooter();
	}

	public function misregistros($page = 1){

		$data = ['from' => 'Mapa/misregistros'];
		$filters = [
            'user' => session()->get('id'),
            'solo_publicos' => false,
            'fecha' => false
        ];
		helper("pagination");

		$quant_results = $this->model->countListado($filters);
        $quant_to_show = 4;
        $dataPag = setPaginationData($data, $quant_results, $quant_to_show, $page);
        
        $data += [
            'mapas' => $this->model->getMapaData($filters, $quant_to_show, $dataPag['start_from_page']),
        ];
		$this->addJs(array(
            'js/mapa/mapa.js'
        ));
		$this->showHeader();
		$this->ShowContent('misregistros', $data);
		$this->showFooter();
	}

	public function crear(){

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

	public function guardar()
	{
		$data = $this->validar($this->model->getFields());
		unset($data['usua_foto']);

		if(empty($id)){
			$data['entr_fechareg'] = date('Y-m-d H:i:s');
			$data['entr_fechapub'] = date('Y-m-d H:i:s');
			$data['entr_tipo_id'] = $this->request->getPost('entr_tipo_id');
			$data['entr_map_lat'] = $this->request->getPost('latitud');
			$data['entr_map_lng'] = $this->request->getPost('longitud');
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
		helper('formulario');
		$this->addCss(array(
			'lib/leaflet/leaflet.css'
		));
		$this->addJs(array(
			'lib/leaflet/leaflet.js',
			'js/mapa/mostrar.js',
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
}
