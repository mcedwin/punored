<?php

namespace App\Controllers;

use App\Models\EntradaModel;
use App\Models\UsuarioModel;

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
        $quant_to_show = 5;
        $dataPag = setPaginationData($data, $quant_results, $quant_to_show, $page);

        //data
        $data += [
            'categorias' => $this->model->getCategorias(),
            'noticias' => $this->model->getDataListado($filters, $quant_to_show, $dataPag['start_from_page']),
        ];

        //Setting relation
        if (!empty($this->user->id)) {
            foreach ($data['noticias'] as $i => $noti) {
                $row = $this->model->getBuilderUsuaEntr($noti['entr_id'], $this->user->id)->select()->get()->getRow();
                if (($row->rela_entr_id ?? $noti['entr_id']) == $noti['entr_id']) {
                    $data['noticias'][$i]['rela_nmas'] = $row->rela_nmas ?? 0;
                    $data['noticias'][$i]['rela_nmenos'] = $row->rela_nmenos ?? 0;
                }
            }
        }
        
        $this->addJs(array(
            'js/entrada/entradas.js'
        ));

        $this->showHeader();
        $this->showContent('index', $data);
        $this->showFooter();
    }

    public function ver($id)
    {
        helper('formulario');
        $entr = $this->model->getEntrada($id);
        $usermod = new UsuarioModel();
        $user = $usermod->getUser($entr->entr_usua_id);
        
        if ($this->model->db->affectedRows() == 0) return redirect()->to(base_url('Noticias'));
        $data = [
            'reg' => (object)((array)$entr + (array)$user),
        ];
        $this->showHeader();
        $this->ShowContent('ver', $data);
        $this->showFooter();
    }

    public function crear()
    {
        if($permiso = $this->diePermiso($this->user->id)) return $permiso;
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
        if($permiso = $this->diePermiso($this->user->id)) return $permiso;
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

        /*$this->db->table('usuario_entrada')
            ->where('rela_usua_id', $this->user->id)
            ->where('rela_entr_id', $id)
            ->delete();*/
        $row = $this->db->query("SELECT * FROM entrada WHERE entr_id='{$id}' AND entr_usua_id='{$this->user->id}'")->getRow();

        $builder
            ->where('entr_id', $id)
            ->where('entr_usua_id', $this->user->id)
            ->delete();


        if($this->model->db->affectedRows() === 0) return 0;

        $this->borrar_imagen('uploads/noticias',$row->entr_foto);

        $this->dieMsg();
        //echo json_encode(['id'=> $id, 'iduser' => $this->user->id]);
    }

    public function setPunto($entrid, $punto)
    {
        $this->dieAjax();
        $this->diePermiso($this->user->id);

        $data = [
            'entr_id' => $entrid,
            'usua_id' => $this->user->id,
            'punto' => $punto,
        ];

        $this->model->insertPoint((object)$data);

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
            'js/entrada/entradas.js'
        ));

        $this->showHeader();
        $this->ShowContent('misregistros', $data);
        $this->showFooter();
    }
    public function test() {
        // $a = null;
        // var_dump(([] ?? true));
        // $this->dieMsg(true, $this->model->getPoints(1, 5)); ===// echo json_encode($this->model->getPoints(1, 5));
        // echo '<pre>'; var_dump($this->db->table('entrada_categoria')->select()->where('cate_tipo_id', 1)->get()->getResultArray()[0]['cate_id']); echo '</pre>';

        // helper('formulario');
        // $a = GetQS('anuncio convocatoria', ['encu_titulo','encu_descripcion','encu_id']);
        // echo '<pre>'; var_dump($a); echo '</pre>';
        // $b = $this->model->db->table('entrada')->like('encu_titulo', 'anuncios')->getCompiledSelect();
        // echo '<pre>'; var_dump($b); echo '</pre>';
        
        $_m = 'as            ds po -';

        $_m = preg_replace("/[ \t]+/i", " ", trim($_m));

        echo '<pre>'; var_dump($_m); echo '</pre>';

        echo '<pre>'; var_dump(explode(" ", 'asd as as')); echo '</pre>';
        echo '<pre>'; var_dump(implode(" OR ", ['asd', 'as', 'as'])); echo '</pre>';
        // ->get()->getResult()
        ;
    }
}
