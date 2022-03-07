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
    $categ_id = $this->request->getGet('categoria') ?? null;
    $filters = ['filtro' => $filter, 'categoria' => $categ_id];

    helper("pagination");
    //Paginacion
    $model = new NoticiasModel();
    $quant_results = $model->countListado($filters);
    $quant_to_show = 3;
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
      'last_page' => $quant_pages + 1 - (($quant_results % $quant_to_show == 0) ? 1 : 0),
      'from' => 'Noticias/index/'
    );
    if(!empty(session()->get('id')))
        $data['misnoticias'] = $model->getBuilder()->where('entr_usua_id', session()->get('id'))->select('entr_id')->get()->getResult();

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
        helper("formulario");
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
      $data['entr_usua_id'] = $this->user->id;
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

        // helper('filesystem');
        // $file = new \CodeIgniter\Files\File("uploads/noticias/img_$id.small.jpg", true);
        // $file->move('uploads/trash/noticias', $file->getBasename(), true);
        // delete_files('uploads/trash/noticias/');

        $model->db->table('usuario_entrada')
            ->where('rela_usua_id', $this->user->id)
            ->where('rela_entr_id', $id)
        ->delete();
        $this->dieMsg();
        echo json_encode(['id'=> $id, 'iduser' => $this->user->id]);
	}

    public function setPunto($punto)
    {
        $this->dieAjax();
        if (is_null($this->user->id)) return "";
        
        $model = new NoticiasModel();

        $data = [
            'entr_id' => $this->request->getPost('entr_id'),
            'usua_id' => $this->user->id
        ];
        if ($punto == 'mas') $data['pmas'] = $punto;
        else if ($punto == 'menos') $data['pmenos'] = $punto;

        $model->insertPoint($data);

        echo json_encode($model->getPoints($data['entr_id'], $data['usua_id']));
    }

    public function misNoticias($page = 1)
    {
        $filter = $this->request->getGet('filtro') ?? 'recientes';
        $categ_id = $this->request->getGet('categoria');
        $filters = [
            'filtro' => $filter,
            'categoria' => $categ_id,
            'user' => session()->get('id'),
            'espublico' => false,
            'fecha' => false
        ];

        //Paginacion
        $model = new NoticiasModel();
        $quant_results = $model->countListado($filters);
        $quant_to_show = 5;
        $page = (int)$page - 1;
        if ($page < 0 || $page * $quant_to_show > $quant_results) {
            return redirect()->to(base_url('Noticias/misnoticias')); // $page = 0;
        }
        $start_from = $page * $quant_to_show;
        $quant_pages = (int) ($quant_results / $quant_to_show);


        $data = array(
            'categorias' => $this->db->table('entrada_categoria')->select(['cate_nombre', 'cate_id'])->get()->getResult(),
            'noticias' => $model->getDataListado($filters, $quant_to_show, $start_from),
            'filtros' => $filters,
            'quant_results' => $quant_results,
            'current_page' => $page + 1,
            'last_page' => $quant_pages + 1 - (($quant_results % $quant_to_show == 0) ? 1 : 0),
            'from' => 'Noticias/misNoticias/'
        );

        $this->addJs(array(
            'js/entrada/noticias.js'
        ));

        if (!empty(session()->get('id')))
        $data['misnoticias'] = $model->getBuilder()->where('entr_usua_id', session()->get('id'))->select('entr_id')->get()->getResult();

        $this->showHeader();
        $this->ShowContent('index', $data);
        $this->showFooter();
    }
  
  public function test3()
  {
    // $model = new NoticiasModel();
    // echo '<pre>'; var_dump($model->getPoints(27,11)); echo '</pre>';
    $a = $this->user->id;
    var_dump($a);
    var_dump(!(bool)[]);
    // echo date('Y-m-d H:i:s');
  }
}
