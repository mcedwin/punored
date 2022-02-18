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
		$datos['fields'] = $this->model->get();
    
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
