<?php

namespace App\Controllers;

use App\Models\PersonaModel;

class Persona extends BaseController
{
  var $model;
  public function __construct()
  {
    $this->model = new PersonaModel();
  }
  
  public function index()
  {
    $this->showHeader();
    $fields = ['*'];
    $data = $this->model->getPersonas($fields);
    $this->showContent('index',['persons'=>$data]);
    $this->showFooter();
  }

  public function crear()
  {
    helper("formulario");

    $datos = [
      'id' => '0',
      'titulo' => 'Ingresar persona',
      'type' => 'hidden',
      'fields' => $this->model->get()
    ];
    
    $this->showHeader();
    $this->ShowContent('form', $datos);
    $this->showFooter();
  }

  public function guardar($id = '')
  {
    $data = [
      'pers_nombre' => $this->input->post('pers_nombre'),
      'pers_email' => $this->input->post('pers_email'),
      'pers_password' =>$this->input->post('pers_password')
    ];

    // $this->form_validation->set_rules('pers_nombre', 'Nombre de usuario', 'required');
    // $this->form_validation->set_rules('pers_email', 'Email', 'required|is_unique[user.email]');
    // $this->form_validation->set_rules('pers_password', 'Password', 'required|min_length[2]');
    

    // if ($this->form_validation->run() == FALSE) {
    //   $this->load->view('persona/form');
    // } else {

      $data['pers_password'] = md5($data['pers_password']);

      $this->model->saveData($data);
      // $this->session->set_flashdata('success', 'Se guardo los datos correctamente');

      redirect(base_url('Persona'));
    // }

  }

  public function editar($id)
  {
    helper("formulario");

    $datos = [
      'id' => $id,
      'titulo' => 'Editar persona',
      'fields' => $this->model->get($id)
    ];

    $this->showHeader();
    $this->ShowContent('form', $datos);
    $this->showFooter();
  }

  public function test()
  {
    $this->showHeader();
    echo '<pre>';
    // var_dump($this->model->get());
    var_dump($this->model->getFldData());
    // var_dump($this->model->getFlds());
    echo '</pre>';
  }
}