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
			'js/directorio/form.js',
		));
		
		$this->showHeader();
		$this->ShowContent('crear', $datos);
		$this->showFooter();
	}
	public function guardar($id = '')
	{
		$model = new DirectorioModel();

		$data = $this->validar($model->getFields());
		if(empty($id)){
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
		$this->dieMsg(true,'', base_url('/'));
	}
}
