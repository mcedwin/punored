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
        $fields = ['*'];
        $data = $this->model->getEstudiantes($fields);
		$this->ShowContent('index', ['estudiantes'=>$data]);
		$this->showFooter();
	}
    public function crear(){
        helper('formulario');
		$this->datos['id'] = '0';
		$this->datos['titulo'] = 'Registrar Estudiante';
		$this->datos['fields'] = $this->model->get();
        
        $this->addJs(array(
            'js/estudiante/form.js'
        ));
    
		$this->showHeader();
		$this->ShowContent('form', $datos);
		$this->showFooter();
    }
    public function guardar($id = '')
	{
        $this->dieAjax();

        $data = [
            'est_nombre' => $this->request->getPost('est_nombre'),
            'est_apellido' => $this->request->getPost('est_apellido'),
            'est_edad' => $this->request->getPost('est_edad')
        ];
        $data = $this->validar($this->model->getFields());

        $this->model->Savedata($data);
        $this->dieMsg(true, '', base_url('Estudiante'));
	}

    public function editar($id)
    {
        
        $this->model->Update($id, $data);
    }

    public function eliminar($id)
    {
        $this->model->Delete($id);
    }
    
}
