<?php

namespace App\Controllers;
use App\Models\EntradaModel;
use App\Models\UsuarioModel;

class Directorio extends BaseController
{
	var $model;
	public function __construct()
	{
		$this->model = new EntradaModel(3);
	}
    public function index($page = 1)
	{
		$this->meta->title = "Directorio";
		$data = ['from' => 'Directorio/index/'];

		//filtroa
		$filter = $this->request->getGet('filtro') ?? 'recientes';
		$categ_id = $this->request->getGet('categoria') ?? null;
		$filters = ['filtro' => $filter, 'categoria' => $categ_id];
		$data['filtros'] = $filters;

		helper("pagination");

		$quant_results = $this->model->countListado($filters);
		$quant_to_show = 5;
		$dataPag = setPaginationData($data, $quant_results, $quant_to_show, $page);

		$data += [
			'categorias' => $this->model->getCategorias(),
			'directorios' => $this->model->getDataListado($filters, $quant_to_show, $dataPag['start_from_page']),
		];

        if (!empty($this->user->id)) {
            $puntos = $this->model->builUsuEntr->select(['rela_entr_id', 'rela_nmas', 'rela_nmenos'])->where('rela_usua_id', $this->user->id)->get()->getResult();
            foreach ($data['directorios'] as $i => $noti) {
                $data['directorios'][$i]['rela_nmas'] = '0';
                $data['directorios'][$i]['rela_nmenos'] = '0';
                foreach ($puntos as $p) {
                    if ($p->rela_entr_id == $noti['entr_id']) {
                        $data['directorios'][$i]['rela_nmas'] = $p->rela_nmas;
                        $data['directorios'][$i]['rela_nmenos'] = $p->rela_nmenos;
                    }
                }
            }
        }

		$this->addJs(array(
			"js/entrada/entradas.js",
		));
		$this->showHeader();
		$this->ShowContent('index', $data);
		$this->showFooter();	
	}
	public function ver($id)
	{
        $entr = $this->model->getEntrada($id);
        $usermod = new UsuarioModel();
        $user = $usermod->getUser($entr->entr_usua_id);
        
        if ($this->model->db->affectedRows() == 0) return redirect()->to(base_url('Directorio'));
        $data = [
            'reg' => (object)((array)$entr + (array)$user),
        ];

		$this->meta->title = $entr->entr_titulo;
        $this->meta->image = get_image('noticias',$entr->entr_foto,'normal');

		$this->showHeader();
		$this->ShowContent('ver', $data);
		$this->showFooter();

	}
	public function crear()
	{
		$this->meta->title = "Crear registro en directorio";
		if($permiso = $this->diePermiso($this->user->id)) return $permiso;
		helper('formulario');
		$datos = [
			'id' => 0,
			'titulo' => 'Publicar Directorio',
			'fields' => $this->model->get()
		];
		$this->addJs(array(
			"lib/tinymce/tinymce.min.js",
			"lib/tinymce/jquery.tinymce.min.js",
			"js/directorio/form.js",
		));
		
		$this->showHeader();
		$this->ShowContent('crear', $datos);
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
			$data['entr_usua_id'] = $this->user->id;
			$this->db->table('entrada')->insert($data);
			$id = $this->db->insertID();
			$path = 'img_'.$id.'.small.jpg';
			if($this->guardar_imagen('uploads/directorio', $path)){
				$this->db->table('entrada')->update(array('entr_foto'=>$path), "entr_id = '{$id}'" );
			}
		}else{
			$path = 'img_'.$id.'.small.jpg';
			if($this->guardar_imagen('uploads/directorio',$path)){
				$data = $data + array('entr_foto' => $path);
			}
			$this->db->table('entrada')->update($data,"entr_id = '{$id}'");
		}
		$this->dieMsg(true,'', base_url('/Directorio/misregistros'));
	}
	public function editar($id)
	{
		if($permiso = $this->diePermiso($this->user->id)) return $permiso;
        helper("formulario");
		$this->addJs(array(
			"lib/tinymce/tinymce.min.js",
			"lib/tinymce/jquery.tinymce.min.js",
			"js/directorio/form.js",	
		));
		$datos['id'] = $id;
		$datos['titulo'] = 'Editar Directorio';
		$datos['fields'] = $this->model->get($id);
		$datos['fields']->entr_foto->value = base_url('uploads/directorio') . (empty($datos['fields']->entr_foto->value) ? '/sinlogo.png' : '/' . $datos['fields']->entr_foto->value);
		//$datos['fields']->entr_descripcion->value = 

		$this->showHeader();
		$this->ShowContent('crear', $datos);
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
        //echo json_encode(['id'=> $id, 'iduser' => $this->user->id]);
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

	public function misregistros($page=1)
	{
		$this->meta->title = "Mis registros";
		$data = ['from' => 'Directorio/misregistros'];
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
            'directorios' => $this->model->getDataListado($filters, $quant_to_show, $dataPag['start_from_page']),
        ];

        $this->addJs(array(
            'js/directorio/directorio.js'
        ));

        $this->showHeader();
        $this->ShowContent('misregistros', $data);
        $this->showFooter();
	}

}
