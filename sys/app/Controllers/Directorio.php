<?php

namespace App\Controllers;
use App\Models\DirectorioModel;

class Directorio extends BaseController
{
	var $model;
	public function __construct()
	{
		$this->model = new DirectorioModel();
	}
    public function index($page = 1)
	{
		$quant_results = $this->model->count();
		$quant_to_show = 5;
		$page = $page - 1;
		if($page < 0 || $page * $quant_to_show > $quant_results){
			return redirect()->to(base_url('Directorio/index'));
		}
		$start_from = $page * $quant_to_show;
		$quant_pages = (int) ($quant_results / $quant_to_show);

		$data = array(
			'directorio' => $this->model->getDirectorioData($quant_to_show, $start_from),
			'quant_results' => $quant_results,
			'current_page' => $page + 1,
			'last_page' => $quant_pages + 1 - (($quant_results % $quant_to_show == 0) ? 1 :0)
		);
		$this->showHeader();
		$this->ShowContent('index', $data);
		$this->showFooter();	
	}
	public function crear()
	{
		helper('formulario');
		$datos = [
			'id' => 0,
			'titulo' => 'Publicar Directorio',
			'fields' => $this->model->get()
		];
		$this->addJs(array(
			'js/directorio/form.js'
		));
		
		$this->showHeader();
		$this->ShowContent('crear', $datos);
		$this->showFooter();
	}
	public function guardar($id = '')
	{
		$data = [
			'dire_nombre' => $this->request->getPost('dire_nombre'),
			'dire_resumen' => $this->request->getPost('dire_resumen'),
			'dire_contenido' =>$this->request->getPost('dire_contenido'),
			'dire_logo' =>$this->request->getPost('dire_logo'),
			'dire_imagen' => $this->request->getPost('dire_imagen'),
			'dire_cate_id' => $this->request->getPost('dire_cate_id')
		];

		$data = $this->validar($this->model->getFields());
		$this->model->saveData($data);
		$this->dieMsg(true,'', base_url('Directorio'));
	}
	
}
