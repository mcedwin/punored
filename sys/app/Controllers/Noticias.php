<?php

namespace App\Controllers;
use App\Models\EntradaModel;
use App\Models\NoticiasModel;

class Noticias extends BaseController
{
  public function index($page = 1)
  {
    $model = new NoticiasModel();
    $quant_results = $model->count();
    $quant_to_show = 5;
    $page -= 1;
    if ($page < 0 || $page * $quant_to_show > $quant_results) {
      return redirect()->to(base_url('Noticias/index'));
      // $page = 0;
    }
    $start_from = $page * $quant_to_show;
    $quant_pages = (int) ($quant_results / $quant_to_show);
      
    $data = array(
      'noticias' => $model->getDataListado($quant_to_show, $start_from),
      'quant_results' => $quant_results,
      'current_page' => $page + 1,
      'last_page' => $quant_pages + 1
    );

    $this->showHeader();
    $this->showContent('index', $data);
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
		$this->addJs(array(
			"lib/tinymce/tinymce.min.js",
			"lib/tinymce/jquery.tinymce.min.js",
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
		$this->addJs(array(
			"lib/tinymce/tinymce.min.js",
			"lib/tinymce/jquery.tinymce.min.js",
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
		$model = new EntradaModel();
    

		$data = $this->validar($model->getFields());
		$data['entr_fechareg'] = date('Y-m-d H:i:s');
		unset($data['usua_foto']);

		if (empty($id)) {
			//$data['entr_usua_id'] = $this->user->id;
			$this->db->table('entrada')->insert($data);
			$id = $this->db->insertID();

			$path = 'img_' . $id . '.small.jpg';
			if ($this->guardar_imagen('uploads/noticias', $path)) {
				$this->db->table('entrada')->update('entrada', array('entr_foto'=>$path), "entr_id='{$id}'"); // AND entr_usua_id={$this->user->id}
			}

		} else {
			$path = 'img_' . $id . '.small.jpg';
			if ($this->guardar_imagen('uploads/noticias', $path)) {
				$data = $data + array('entr_foto' => $path);
			}
			$this->db->table('entrada')->update($data, "entr_id='{$id}'"); // AND entr_usua_id={$this->user->id}
		}

		$this->dieMsg(true,'',base_url('/'));
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
    $model = new NoticiasModel();
    $datos = $model->count();
    echo '<pre>'; var_dump($datos); echo '</pre>';
  }
}
