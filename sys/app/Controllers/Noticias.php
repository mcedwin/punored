<?php

namespace App\Controllers;
use App\Models\EntradaModel;
use App\Models\NoticiasModel;

class Noticias extends BaseController
{
  public function index($page = 1)
  {
    
    //filtros
    $filter = $this->request->getGet('filtro') ?? 'recientes';
    $categ_id = $this->request->getGet('categoria');
    $filters = ['filtro' => $filter, 'categoria' => $categ_id];

    //Paginacion
    $model = new NoticiasModel();
    $quant_results = $model->countListado($filters);
    $quant_to_show = 5;
    $page = (int)$page - 1;
    if ($page < 0 || $page * $quant_to_show > $quant_results) {
      return redirect()->to(base_url('Noticias/index')); // $page = 0;
    }
    $start_from = $page * $quant_to_show;
    $quant_pages = (int) ($quant_results / $quant_to_show);
    
    
    $data = array(
      'categorias' => $this->db->table('entrada_categoria')->select(['cate_nombre','cate_id'])->get()->getResult(),
      'noticias' => $model->getDataListado($filters, $quant_to_show, $start_from),
      'filtros' => $filters,
      'quant_results' => $quant_results,
      'current_page' => $page + 1,
      'last_page' => $quant_pages + 1 - (($quant_results % $quant_to_show == 0) ? 1 : 0)
    );

    $this->addJs(array(
      'js/entrada/noticias.js'
    ));

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
    $id = '';
    
		$data = $this->validar($model->getFields());
		$data['entr_fechareg'] = date('Y-m-d H:i:s');
		unset($data['usua_foto']);

		if (empty($id)) {
      $data['entr_tipo_id'] = $this->request->getPost('entr_tipo_id');
			//$data['entr_usua_id'] = $this->user->id;
			$this->db->table('entrada')->insert($data);
			$id = $this->db->insertID();

			$path = 'img_' . $id . '.small.jpg';
			if ($this->guardar_imagen('uploads/noticias', $path)) {
				$this->db->table('entrada')->update(array('entr_foto'=>$path), "entr_id='{$id}'"); // AND entr_usua_id={$this->user->id}
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

	public function eliminar($id)
	{
    $model = new NoticiasModel();
    $builder = $model->getBuilder();
		$this->dieAjax();
    $builder
      ->where('entr_id', $id)
      ->where('entr_usua_id', $this->user->id)
    ->delete();
		$this->dieMsg();
	}

  public function setPunto($punto)
  {
    $this->dieAjax();
    $model = new NoticiasModel();

    $data = [
      'entr_id' => $this->request->getPost('entr_id'),
      'usua_id' => $this->request->getPost('usua_id'),
    ];
    if ($punto == '1') $data['pmas'] = $punto;
    else if ($punto == '-1') $data['pmenos'] = $punto;
    else redirect()->to(base_url('Noticias'));

    $model->insertPoint($data);

    // echo "<pre>";
    // echo "<response>";
    echo json_encode($model->getPoints($data['entr_id'], $data['usua_id']));
    // echo "</response>";
    // echo "</pre>";
  }
  
  public function test3()
  {
    $model = new NoticiasModel();
    // echo '<pre>'; var_dump($model->getLastPoints2()); echo '</pre>';
    // echo (null > 5)?"yes":"no";
    echo '<script>
    $html = document.querySelector("html");
    $html.innerHTML = "";
    </script>';
    // echo "<pre>";
    // echo "<response id='#response'>";
    echo json_encode($model->getPoints(5, 1));
    // var_dump( $model->getPoints(5, 1));
    // echo "</response>";
    // echo "</pre>";
  }
}
