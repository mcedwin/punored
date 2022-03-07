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
		$filter = $this->request->getGet('filtro') ?? 'recientes';
		$categ_id = $this->request->getGet('categoria');
    	$filters = ['filtro' => $filter, 'categoria' => $categ_id];

		$quant_results = $this->model->countListado($filters);
		$quant_to_show = 5;
		$page = (int)$page - 1;
		if($page < 0 || $page * $quant_to_show > $quant_results){
			return redirect()->to(base_url('Directorio/index'));
		}
		$start_from = $page * $quant_to_show;
		$quant_pages = (int) ($quant_results / $quant_to_show);

		$data = array(
			'categorias' => $this->db->table('entrada_categoria')->select(['cate_nombre','cate_id'])->get()->getResult(),
			'directorios' => $this->model->getDirectorioData($filters, $quant_to_show, $start_from),
			'filtros' => $filters,
			'quant_results' => $quant_results,
			'current_page' => $page + 1,
			'last_page' => $quant_pages + 1 - (($quant_results % $quant_to_show == 0) ? 1 :0),
			'from' => 'Directorio/index/'
		);
		if(!empty(session()->get('id')))
        $data['misdirectorios'] = $this->model->getBuilder()->where('entr_usua_id', session()->get('id'))->select('entr_id')->get()->getResult();

		$this->addJs(array(
			"js/directorio/directorio.js",
			
		));
		$this->showHeader();
		$this->ShowContent('index', $data);
		$this->showFooter();	
	}

	public function misregistros(){
		$this->showHeader();
		$this->ShowContent('misregistros');
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
			"lib/tinymce/tinymce.min.js",
			"lib/tinymce/jquery.tinymce.min.js",
			"js/directorio/form.js",
			
		));
		
		$this->showHeader();
		$this->ShowContent('crear', $datos);
		$this->showFooter();
	}
	public function guardar($id = '')
	{
		$id = '';

		$data = $this->validar($this->model->getFields());
		$data['entr_fechareg'] = date('Y-m-d H:i:s');
		unset($data['usua_foto']);

		
		if(empty($id)){
			$data['entr_tipo_id'] = $this->request->getPost('entr_tipo_id');
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
	public function editar($id)
	{
        helper("formulario");
		$this->addJs(array(
			"lib/tinymce/tinymce.min.js",
			"lib/tinymce/jquery.tinymce.min.js",
			"js/directorio/form.js",	
		));

		$model = new EntradaModel();
		$datos['id'] = $id;
		$datos['titulo'] = 'Editar noticia';
		$datos['fields'] = $model->get($id);
		$datos['fields']->entr_foto->value = base_url('uploads/noticias') . (empty($datos['fields']->entr_foto->value) ? '/sinlogo.png' : '/' . $datos['fields']->entr_foto->value);
		//$datos['fields']->entr_descripcion->value = 

		$this->showHeader();
		$this->ShowContent('crear', $datos);
		$this->showFooter();
	}
	public function eliminar()
	{
		$builder = $this->model->getBuilder();
		$this->dieAjax();
        $builder
            ->where('entr_id', $id)
            ->where('entr_usua_id', $this->user->id)
        ->delete();
		$this->model->db->table('usuario_entrada')
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

		$data = [
			'entr_id' => $this->request->getPost('entr_id'),
			'usua_id' => $this->request->getPost('usua_id'),
		];
		if ($punto == 'mas') $data['pmas'] = $punto;
		else if ($punto == 'menos') $data['pmenos'] = $punto;

		$model->insertPoint($data);

		echo json_encode($this->model->getPoints($data['entr_id'], $data['usua_id']));
	}
	public function misDirectorios($page=1)
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
		$quant_results = $this->model->countListado($filters);
        $quant_to_show = 5;
        $page = (int)$page - 1;
        if ($page < 0 || $page * $quant_to_show > $quant_results) {
            return redirect()->to(base_url('Directorio/misdirectorios')); // $page = 0;
        }
        $start_from = $page * $quant_to_show;
        $quant_pages = (int) ($quant_results / $quant_to_show);


        $data = array(
            'categorias' => $this->db->table('entrada_categoria')->select(['cate_nombre', 'cate_id'])->get()->getResult(),
            'directorios' => $this->model->getDataListado($filters, $quant_to_show, $start_from),
            'filtros' => $filters,
            'quant_results' => $quant_results,
            'current_page' => $page + 1,
            'last_page' => $quant_pages + 1 - (($quant_results % $quant_to_show == 0) ? 1 : 0),
            'from' => 'Directorio/misDirectorios/'
        );

        $this->addJs(array(
            'js/directorio/directorio.js'
        ));

        if (!empty(session()->get('id')))
        $data['misdirectorios'] = $this->model->getBuilder()->where('entr_usua_id', session()->get('id'))->select('entr_id')->get()->getResult();

        $this->showHeader();
        $this->ShowContent('index', $data);
        $this->showFooter();
	}

}
