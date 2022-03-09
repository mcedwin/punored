<?php

namespace App\Controllers;

use App\Models\EntradaModel;

class Noticias extends BaseController
{
    var $model;
    public function __construct()
    {
        $this->model = new EntradaModel(1);
    }
    public function index(?int $page = 1)
    {
        $data = ['from' => 'Noticias/index/'];

        //filtros
        $filter = $this->request->getGet('filtro') ?? 'recientes';
        $categ_id = $this->request->getGet('categoria') ?? null;
        $filters = ['filtro' => $filter, 'categoria' => $categ_id];
        $data['filtros'] = $filters;

        helper("pagination");
        //Paginacion
        $quant_results = $this->model->countListado($filters);
        $quant_to_show = 3;
        $dataPag = setPaginationData($data, $quant_results, $quant_to_show, $page);

        //data
        $data += [
            'categorias' => $this->db->table('entrada_categoria')->select(['cate_nombre', 'cate_id'])->get()->getResult(),
            'noticias' => $this->model->getDataListado($filters, $quant_to_show, $dataPag['start_from_page']),
        ];

        if (!empty(session()->get('id')))
            $data['misnoticias'] = $this->model->getBuilder()->where('entr_usua_id', session()->get('id'))->select('entr_id')->get()->getResult();

        $this->addJs(array(
            'js/entrada/noticias.js'
        ));

        $this->showHeader();
        $this->showContent('index', $data);
        $this->showFooter();
    }

    public function ver($id)
    {
        $res = $this->model->getBuilder()->where('entr_id', $id)->select()->get()->getRow();
        if ($this->model->db->affectedRows() == 0) return redirect()->to(base_url('Noticias'));
        $data = [
            'reg' => $res
        ];
        $this->showHeader();
        $this->ShowContent('ver', $data);
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

        $datos['id'] = '0';
        $datos['titulo'] = 'Publicar noticia';
        $datos['fields'] = $this->model->get();

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

        $datos['id'] = $id;
        $datos['titulo'] = 'Editar noticia';
        $datos['fields'] = $this->model->get($id);
        $datos['fields']->entr_foto->value = base_url('uploads/noticias') . (empty($datos['fields']->entr_foto->value) ? '/sinlogo.png' : '/' . $datos['fields']->entr_foto->value);
        //$datos['fields']->entr_descripcion->value = 

        $this->showHeader();
        $this->ShowContent('form', $datos);
        $this->showFooter();
    }

    public function guardar($id = '')
    {
        $data = $this->validar($this->model->getFields());
        unset($data['usua_foto']);

        if (empty($id)) {
            $data['entr_fechareg'] = date('Y-m-d H:i:s');
            $data['entr_fechapub'] = date('Y-m-d H:i:s');
            $data['entr_tipo_id'] = $this->request->getPost('entr_tipo_id');
            $data['entr_usua_id'] = $this->user->id;
            $this->db->table('entrada')->insert($data);
            $id = $this->db->insertID();

            $path = 'img_' . $id . '.small.jpg';
            if ($this->guardar_imagen('uploads/noticias', $path)) {
                $this->db->table('entrada')->update(array('entr_foto' => $path), "entr_id='{$id}'"); // AND entr_usua_id={$this->user->id}
            }
        } else {
            $path = 'img_' . $id . '.small.jpg';
            if ($this->guardar_imagen('uploads/noticias', $path)) {
                $data = $data + array('entr_foto' => $path);
            }
            $this->db->table('entrada')->update($data, "entr_id='{$id}'"); // AND entr_usua_id={$this->user->id}
        }

        $this->dieMsg(true, '', base_url('/Noticias/misnoticias'));
    }

    public function eliminar($id)
    {
        $builder = $this->model->getBuilder();
        $this->dieAjax();

        $this->db->table('usuario_entrada')
            ->where('rela_usua_id', $this->user->id)
            ->where('rela_entr_id', $id)
            ->delete();

        $builder
            ->where('entr_id', $id)
            ->where('entr_usua_id', $this->user->id)
            ->delete();
        // if($model->db->affectedRows() === 0) return 0;
        // helper('filesystem');
        // $file = new \CodeIgniter\Files\File("uploads/noticias/img_$id.small.jpg", true);
        // $file->move('uploads/trash/noticias', $file->getBasename(), true);
        // delete_files('uploads/trash/noticias/');

        $this->dieMsg();
        //echo json_encode(['id'=> $id, 'iduser' => $this->user->id]);
    }

    public function setPunto($entrid, $punto)
    {
        $this->dieAjax();
        if (is_null($this->user->id)) return "";

        $data = [
            'entr_id' => $entrid,
            'usua_id' => $this->user->id
        ];
        if ($punto == 'mas') $data['pmas'] = $punto;
        else if ($punto == 'menos') $data['pmenos'] = $punto;

        $this->model->insertPoint($data);

        echo json_encode($this->model->getPoints($data['entr_id'], $data['usua_id']));
    }

    public function misnoticias($page = 1)
    {
        $data = ['from' => 'Noticias/misnoticias'];

        $filters = [
            'user' => $this->user->id,
            'solo_publicos' => false,
            'fechapub' => false
        ];

        helper('pagination');
        $quant_results = $this->model->countListado($filters);
        $quant_to_show = 4;
        $dataPag = setPaginationData($data, $quant_results, $quant_to_show, $page);

        $data += [
            'noticias' => $this->model->getDataListado($filters, $quant_to_show, $dataPag['start_from_page']),
        ];

        $this->addJs(array(
            'js/entrada/noticias.js'
        ));

        $this->showHeader();
        $this->ShowContent('misregistros', $data);
        $this->showFooter();
    }
}
