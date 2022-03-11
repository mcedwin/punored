<?php

namespace App\Controllers;

use App\Models\EncuestasModel;
use App\Models\EntradaModel;

class Encuestas extends BaseController
{
    var $model;
    
    public function __construct()
    {
        $this->model = new EncuestasModel();
    }
    
    public function index($rowno = 0)
	{
		// $sql = "SELECT * FROM encuesta WHERE encu_actual=true LIMIT 1";
		// $this->datos['encuesta'] = $row = $this->db->query($sql)->getRow();
		// $this->datos['detalle'] = $this->db->query("SELECT * FROM encuesta_detalle WHERE deta_encu_id='{$row->encu_id}'")->getResult();
        $this->datos['encuesta'] = $row = $this->model->getEncuesta(1);
        $this->datos['detalle'] = $this->model->getEncuDetalle($row->encu_id);

		$this->addJs(array(
			'js/encuesta/votar.js'
		));
		$this->showHeader();
		$this->ShowContent('index');
		$this->showFooter();
	}

	public function misencuestas($page = 1) {
        $data = ['from' => 'Encuestas/misencuestas'];

        $filters = [
            'usuario' => $this->user->id,
        ];
        
        helper('pagination');
        $quant_results = $this->model->countListado('*', $filters);
        $quant_to_show = 3;
        $dataPag = setPaginationData($data, $quant_results, $quant_to_show, $page);
        
        $data['encuestas'] = $this->model->getListado($filters, $quant_to_show, $dataPag['start_from_page']);
        
        $this->addJs(
            'js/encuesta/form.js',
        );
        
		$this->showHeader();
		$this->ShowContent('misencuestas', $data);
		$this->showFooter();
	}

	public function crear(){
        helper("formulario");
        $this->addJs(array(
            "lib/tinymce/tinymce.min.js",
            "lib/tinymce/jquery.tinymce.min.js",
            'js/encuesta/publicar.js',
            'js/encuesta/form.js',
        ));
        $datos = [
            'id' => '0',
            'titulo' => 'Publicar encuesta',
            'fields' => $this->model->get()
        ];

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
            'js/encuesta/publicar.js',
            'js/encuesta/form.js',
        ));
        $datos = [
            'id' => $id,
            'titulo' => 'Editar encuesta',
            'fields' => $this->model->get($id),
        ];
        $datos['detalle'] = $this->model->getEncuDetalle($id);
        $datos['fields']->encu_foto->value = base_url('uploads/encuestas') . (empty($datos['fields']->encu_foto->value) ? '/sinlogo.png' : '/' . $datos['fields']->encu_foto->value);

        $this->showHeader();
        $this->ShowContent('form', $datos);
        $this->showFooter();
    }

    public function guardar($id = '')
    {
        $data = $this->validar($this->model->fields);
        
        if (empty($id)) {
            $data['encu_actual'] = true;
            $data['encu_titulo'] = $this->request->getPost('encu_titulo');
            $data['encu_usua_id'] = $this->user->id;
            $this->model->db->table('encuesta')->insert($data);
            $id = $this->db->insertID();

            $path = 'img_' . $id . '.small.jpg';
            if ($this->guardar_imagen('uploads/encuestas', $path)){
                $this->model->db->table('encuesta')->where('encu_id', $id)->update(['encu_foto'=> $path]);//->where('encu_usua_id', $this->user->id)
            }
        } else {
            $path = 'img_' . $id . '.small.jpg';
            if ($this->guardar_imagen('uploads/encuestas', $path)) {
                $data += ['encu_foto' => $path];
            }
            $this->model->db->table('encuesta')->where('encu_id', $id)->update($data); //->where('encu_usua_id', $this->user->id)

            //detalles update
            $this->model->db->table('encuesta_detalle')->where('deta_encu_id',$id)->delete();
        }
        //detalles insert
        $dataDet['deta_encu_id'] = $id;
        for ($i = 1; isset($_POST["alternativa$i"]); $i++) {
            $dataDet['deta_alternativa'] = $this->request->getPost("alternativa$i");
            if (empty($dataDet['deta_alternativa'])) continue;
            $this->model->db->table('encuesta_detalle')->insert($dataDet);
        }
        
        $this->dieMsg(true, '', base_url('/Encuestas/misencuestas'));
    }

    public function eliminar($id)
    {
        $this->dieAjax();
        $encu_user = $this->model->db->table('encuesta')->select('encu_usua_id')->where('encu_id', $id)->get()->getRow()->encu_usua_id;
        if($this->user->id != $encu_user) return ;
        $this->model->builUsuEnc->where('rela_encu_id', $id)->delete();
        $this->model->builDetail->where('deta_encu_id', $id)->delete();
        $this->model->builder->where('encu_id', $id)->delete();//where('encu_usua_id', $this->user->id);
        $this->dieMsg();
    }

    public function ver($id)
    {
        $data['encuesta'] = $this->model->getEncuesta($id);
        $data['detalle'] = $this->model->getEncuDetalle($id);

        $this->addJs(array(
            'js/encuesta/votar.js'
        ));

        $this->showHeader();
        $this->showContent('ver', $data);
        $this->showFooter();
    }
    
    public function voto($deta_id)
    {
        $this->dieAjax();
        $encu_id = $this->model->builDetail->select('deta_encu_id')->where('deta_id', $deta_id)->get()->getRow()->deta_encu_id;
        $rela_exist = $this->model->builUsuEnc->select()->where(['rela_usua_id' => $this->user->id, 'rela_encu_id' => $encu_id])->get()->getRow();
        //rela_usua_valora = false || no existe(==null)
        if ($rela_exist != null) return $this->dieMsg();

        $data['rela_usua_id'] = $this->user->id;
        $data['rela_encu_id'] = $encu_id;
        $data['rela_deta_id'] = $deta_id;
        $data['rela_fechareg'] = date('Y-m-d H:i:s');
        $data['rela_valora'] = true;

        $this->model->builUsuEnc->insert($data);
        
        $newPoints = 1 + (int)($this->model->builDetail->select('deta_puntos')->where('deta_id', $deta_id)->get()->getRow()->deta_puntos);
        $this->model->builDetail->where('deta_id', $deta_id)->set('deta_puntos',$newPoints)->update();
        echo json_encode($newPoints);
    }

    public function test() {
        // echo '<pre>'; var_dump($a); echo '</pre>';
    }
}
