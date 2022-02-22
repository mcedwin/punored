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
    public function index()
	{

		$this->showHeader();
		$this->ShowContent('index');
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
		//$this->dieAjax();

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
		$this->dieMsg(true, '', base_url('Directorio'));
	}
	
}
