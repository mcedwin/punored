<?php

namespace App\Controllers;
use App\Models\EntradaModel;
use App\Models\NoticiasModel;

class Noticias extends BaseController
{
    public function index($rowno = 0)
	{
		$this->showHeader();
		$this->ShowContent('index');
		$this->showFooter();
	}

  public function index2()
  {
    $model = new NoticiasModel();

    $data = $model->getDataListaNoticia();

    $this->showHeader();
    $this->showContent('index2', ['noticias' => $data]);
    $this->showFooter();
  }

	public function ver($id)
	{
		$this->showHeader();
		$this->ShowContent('ver');
		$this->showFooter();
	}

	public function crear()
	{
		helper("formulario");
		//$this->permitir_acceso();
		$this->addCss(array('lib/select2/dist/css/select2.min'));
		$this->addJs(array(
			"lib/tinymce/tinymce.min.js",
			"lib/tinymce/jquery.tinymce.min.js",
			'js/habilidad/scripts.js',
			'js/entrada/publicar.js'
		));

		$model = new EntradaModel();
		$datos['id'] = '0';
		$datos['titulo'] = 'Publicar noticia';
		$datos['fields'] = $model->get();

		$this->showHeader();
		$this->ShowContent('form', $datos);
		$this->showFooter();
	}

	
	public function editar($id)
	{
		$this->addCss(array('lib/select2/dist/css/select2.min'));
		$this->addJs(array(
			"lib/tinymce/tinymce.min.js",
			"lib/tinymce/jquery.tinymce.min.js",
			'lib/select2/dist/js/select2.js',
			'js/habilidad/scripts.js',
			'js/entrada/publicar.js'
		));

		$model = new EntradaModel();
		$datos['id'] = $id;
		$datos['titulo'] = 'Editar noticia';
		$datos['fields'] = $model->get($id);
		$datos['fields']->entr_foto->value = base_url('uploads/noticias') . (empty($datos['fields']->entr_foto->value) ? '/sinlogo.png' : '/' . $datos['fields']->entr_foto->value);
		//$datos['fields']->entr_descripcion->value = 

		$this->showHeader();
		$this->ShowContent('form', $datos);
		$this->showFooter();
	}

	public function guardar($id = '')
	{
		$this->load->model('Model_entrada');
		$data = $this->validar($this->Model_entrada->getFields());
		$data['entr_fechareg'] = date('Y-m-d H:i:s');
		unset($data['usua_foto']);

		if (empty($id)) {
			$data['entr_usua_id'] = $this->user->id;
			$this->db->table('entrada')->insert($data);
			$id = $this->db->insert_id();

			/*$path = 'img_' . $id . '.small.jpg';
			if ($this->guardar_imagen('uploads/entrada', $path)) {
				$this->db->update('entrada', array('entr_foto'=>$path), "entr_id='{$id}' AND entr_usua_id={$this->user->id}");
			}*/

		} else {
			/*$path = 'img_' . $id . '.small.jpg';
			if ($this->guardar_imagen('uploads/entrada', $path)) {
				$data = $data + array('entr_foto' => $path);
			}*/
			$this->db->table('entrada')->update($data, "entr_id='{$id}' AND entr_usua_id={$this->user->id}");
		}

		$this->dieMsg(true);
	}

  public function guardar2()
  {
    $model = new EntradaModel();
    $data = $this->validar($model->getFields());
    $data['entr_fechareg'] = date('Y-m-d H:i:s');
    $data['entr_usua_id'] = $this->user->id;
    $this->db->table('entrada')->insert($data);
    $id = $this->db->insert_id();
    $this->dieMsg(true);
  }

	public function eliminar($id)
	{
		$this->dieAjax();
		$this->db->query("DELETE FROM entrada WHERE entr_id='{$id}' AND entr_usua_id='{$this->user->id}'");
		$this->dieMsg();
	}

  public function test()
  {
    $this->showHeader();
    $model = new EntradaModel();
    $datos['fields'] = $model->get();
    echo '<pre>'; var_dump($datos); echo '</pre>';
  }
}
