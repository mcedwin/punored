<?php

namespace App\Controllers;
use App\Models\EntradaModel;
use App\Models\UsuarioModel;

class Anuncios extends BaseController
{
	var $model;
	public function __construct()
	{
		$this->model = new EntradaModel(2);
	}
	public function index($page = 1)
	{
		$data = ['from' => 'Anuncios/index/'];

		$filter = $this->request->getGet('filtro') ?? 'recientes';
		$categ_id = $this->request->getGet('categoria');
		$filters = ['filtro' => $filter, 'categoria' => $categ_id];
		$data['filtros'] = $filters;

		helper('pagination');

		$quant_results = $this->model->countListado($filters);
		$quant_to_show = 5;
		$dataPag = setPaginationData($data, $quant_results, $quant_to_show, $page);

		$data += [
			'categorias' => $this->db->table('entrada_categoria')->select(['cate_nombre','cate_id'])->get()->getResult(),
			'anuncios' => $this->model->getDataListado($filters, $quant_to_show, $dataPag['start_from_page']),
		];

		$this->addJs(array(
			"js/entrada/entradas.js",
		));
		$this->showHeader();
		$this->showContent('index', $data);
		$this->showFooter();
	}

	public function ver($id)
	{
        $entr = $this->model->getEntrada($id);
        $usermod = new UsuarioModel();
        $user = $usermod->getUser($entr->entr_usua_id);
        
        if ($this->model->db->affectedRows() == 0) return redirect()->to(base_url('Anuncios'));
        $data = [
            'reg' => (object)((array)$entr + (array)$user)
        ];
		$this->showHeader();
		$this->ShowContent('ver', $data);
		$this->showFooter();
	}

	public function crear()
	{
		helper("formulario");
		$this->addJs(array(
			"lib/tinymce/tinymce.min.js",
			"lib/tinymce/jquery.tinymce.min.js",
			'js/anuncios/form.js'
		));
		$datos['id'] = '0';
		$datos['titulo'] = 'Publicar Anuncio';
		$datos['fields'] = $this->model->get();

		$this->showHeader();
		$this->ShowContent('form', $datos);
		$this->showFooter();
	}
	public function misanuncios($page = 1){
		$data = ['from' => 'Anuncios/misanuncios'];
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
            'anuncios' => $this->model->getDataListado($filters, $quant_to_show, $dataPag['start_from_page']),
        ];

        $this->addJs(array(
            'js/anuncios/anuncios.js'
        ));

        $this->showHeader();
        $this->ShowContent('misregistros', $data);
        $this->showFooter();
	}

		
	public function editar($id)
	{
		helper("formulario");
		$this->addJs(array(
			"lib/tinymce/tinymce.min.js",
			"lib/tinymce/jquery.tinymce.min.js",
			"js/anuncios/form.js",	
		));
		$datos['id'] = $id;
		$datos['titulo'] = 'Editar Anuncio';
		$datos['fields'] = $this->model->get($id);
		$datos['fields']->entr_foto->value = base_url('uploads/anuncios') . (empty($datos['fields']->entr_foto->value) ? '/sinlogo.png' : '/' . $datos['fields']->entr_foto->value);
		
		$this->showHeader();
		$this->ShowContent('form', $datos);
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
			if($this->guardar_imagen('uploads/anuncios', $path)){
				$this->db->table('entrada')->update(array('entr_foto'=>$path), "entr_id = '{$id}'" );
			}
		}else{
			$path = 'img_'.$id.'.small.jpg';
			if($this->guardar_imagen('uploads/anuncios',$path)){
				$data = $data + array('entr_foto' => $path);
			}
			$this->db->table('entrada')->update($data,"entr_id = '{$id}'");
		}
		$this->dieMsg(true,'', base_url('/Anuncios/misanuncios'));
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
		if (is_null($this->user->id)) return "";

		$data = [
			'entr_id' => $entrid,
			'usua_id' => $this->user->id,
            'punto' => $punto,
		];

		$this->model->insertPoint($data);

		echo json_encode($this->model->getPoints($data['entr_id'], $data['usua_id']));
	}



}
