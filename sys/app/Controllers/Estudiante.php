<?php

namespace App\Controllers;
use App\Models\EstuModel;

class Estudiante extends BaseController
{
    var $model;
    public function __construct()
    {
        $this->model = new EstuModel();
    }
    public function index()
	{   
        $this->showHeader();
        $datos = $this->model->get();
		$this->ShowContent('index', ['estudiantes'=>$datos]);
		$this->showFooter();
	}
    public function crear(){
        helper('formulario');
		$datos['id'] = '0';
		$datos['titulo'] = 'Registrar Estudiante';
<<<<<<< HEAD
		$datos['fields'] = $this->model->get();
=======
		$datos['fields'] = $model->get();
        $this->addCss(array('lib/select2/dist/css/select2.min'));
		$this->addJs(array(
			"lib/tinymce/tinymce.min.js",
			"lib/tinymce/jquery.tinymce.min.js",
			'js/entrada/publicar.js'
		));

>>>>>>> a23c4c15473089fd26a337b5610570c0091389f5
		$this->showHeader();
		$this->ShowContent('form', $datos);
		$this->showFooter();
    }
    public function guardar($id = '')
	{
        $data = [
            'est_nombre' => $this->input->getPost('est_nombre'),
            'est_apellido' => $this->input->getPost('est_apellido'),
            'est_edad' => $this->input->getPost('est_edad')
        ];

        $this->model->Savedata($data);
	}
    
}
