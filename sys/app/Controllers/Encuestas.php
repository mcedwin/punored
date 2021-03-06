<?php

namespace App\Controllers;

use App\Models\EncuestasModel;
use App\Models\EntradaModel;
use App\Models\UsuarioModel;

class Encuestas extends BaseController
{
    var $model;
    var $usuaModel;
    
    public function __construct()
    {
        $this->model = new EncuestasModel();
        $this->usuaModel = new UsuarioModel();
    }
    
    public function index1()
	{
        $this->meta->title = "Encuestas";
        
		$this->addJs(array(
			'js/encuesta/votar.js'
		));
		$this->showHeader();
		$this->ShowContent('2022');
		$this->showFooter();
	}


    public function index($rowno = 0)
	{
        $this->meta->title = "Encuestas";
        $data['encuesta'] = $row = $this->model->builder->select()->limit(1)->where('encu_actual', true)->get()->getRow();
        $data['detalle'] = $this->model->getEncuDetalle($row->encu_id);
        $data['activas'] = $this->model->builder->select()->limit(3,1)->where('encu_actual', true)->get()->getResult();
        $data['anteriores'] = $this->model->builder->select()->limit(3)->where('encu_actual', false)->get()->getResult();
        $data['miembros'] = $this->usuaModel->getUser('0', ['usua_id', 'usua_nombres', 'usua_apellidos', 'usua_foto']);

		$this->addJs(array(
			'js/encuesta/votar.js'
		));
		$this->showHeader();
		$this->ShowContent('index', $data);
		$this->showFooter();
	}

	public function misencuestas($page = 1) {
        $this->meta->title = "Mis encuestas";
        $data = ['from' => 'Encuestas/misencuestas'];

        $filters = [
            'usuario' => $this->user->id,
        ];
        
        helper('pagination');
        $quant_results = $this->model->countListado($filters);
        $quant_to_show = 5;
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
        $this->meta->title = "Crear encuesta";
        if($permiso = $this->diePermiso($this->user->id)) return $permiso;
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
        $this->meta->title = "Editar encuesta";
        if($permiso = $this->diePermiso($this->user->id)) return $permiso;
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

        }
        $dataDeta = $this->model->builDetail->select()->where('deta_encu_id', $id)->get()->getResult();
        $quant = count($dataDeta);
        //detalles insert
        $dataDet['deta_encu_id'] = $id;
        $no = implode(",",array_filter($_POST["conid"]));
        if(!empty($no)) $this->db->query("DELETE FROM encuesta_detalle WHERE deta_encu_id='{$id}' AND deta_id NOT IN ($no)");

        foreach($_POST["alternativa"] as $i=>$alternativa) {
            $dataDet['deta_alternativa'] = $alternativa;
            
           
           
           $iddet = 0;
            if(!empty($_POST['conid'][$i])){
                $iddet = $_POST['conid'][$i];
                $this->model->builDetail->where('deta_id', $_POST['conid'][$i])->update(['deta_alternativa' => $dataDet['deta_alternativa']]);
            } else {
                $dataDet['deta_puntos'] = 0;
                if (empty($dataDet['deta_alternativa'])) continue;
                $this->model->db->table('encuesta_detalle')->insert($dataDet);
                $iddet = $this->db->insertID();
            }
            $path = 'imagen_'.$id.'_'.$iddet.'.jpg';
            if ($this->guardar_imagen_e("archivo",$i,'uploads/encuestas', $path)) {
                
                $adddata = ['deta_foto' => $path];
                $this->model->builDetail->where('deta_id', $iddet)->update($adddata);
            }
           
        }
        
        $this->dieMsg(true, '', base_url('/Encuestas/misencuestas'));
    }


    public function prueba(){
        $arra = [];
        $im = implode(",",array_filter($arra));
        echo $im;
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
        $reg = $data['encuesta'] = $this->model->getEncuesta($id);
        $data['detalle'] = $this->model->getEncuDetalle($id);



        $this->addJs(array(
            'js/encuesta/votar.js'
        ));

        $this->meta->title = $reg->encu_titulo;
        $this->meta->image = get_image('encuestas',$reg->encu_foto,'normal');

        $this->showHeader();
        $this->showContent('ver'.(empty($data['detalle'][0]->deta_foto)?'':'2'), $data);
        $this->showFooter();
    }
    
    public function voto($deta_id)
    {
        $this->dieAjax();
        $this->diePermiso($this->user->id);
        
        $dataDeta = $this->model->builDetail->select()->where('deta_id', $deta_id)->get()->getRow();//aumenta punto
        $dataUsuEnc = $this->model->builUsuEnc->select()->where(['rela_usua_id' => $this->user->id, 'rela_encu_id' => $dataDeta->deta_encu_id])->get()->getRow();//reaccion usuario
        $dataEncu = $this->model->builder->select('encu_actual')->where('encu_id', $dataDeta->deta_encu_id)->get()->getRow();
        
        if ($dataEncu->encu_actual == false) return $this->dieMsg(false, ['failed'], 'Encuestas');
        
        if ($dataUsuEnc == null) {//no existe registro
            $data['rela_usua_id'] = $this->user->id;
            $data['rela_encu_id'] = $dataDeta->deta_encu_id;
            $data['rela_deta_id'] = $deta_id;
            $data['rela_fechareg'] = date('Y-m-d H:i:s');
            $data['rela_valora'] = true;
            $this->model->builUsuEnc->insert($data);
            
            $newPoints = 1 + (int)($this->model->builDetail->select('deta_puntos')->where('deta_id', $deta_id)->get()->getRow()->deta_puntos);
            $this->model->builDetail->where('deta_id', $deta_id)->set('deta_puntos',$newPoints)->update();
        } else {
            if ($dataUsuEnc->rela_deta_id != $deta_id) {//vota por otro
                $this->model->builUsuEnc->where(['rela_usua_id' => $this->user->id, 'rela_encu_id' => $dataDeta->deta_encu_id])->update(['rela_deta_id' => $deta_id]);
                
                $newPointPlus = 1 + (int)($this->model->builDetail->select('deta_puntos')->where('deta_id', $deta_id)->get()->getRow()->deta_puntos ?? 0);
                $this->model->builDetail->where('deta_id', $deta_id)->update(['deta_puntos' => $newPointPlus]);
                
                $newPointMinus = -1 + (int)($this->model->builDetail->select('deta_puntos')->where('deta_id', $dataUsuEnc->rela_deta_id)->get()->getRow()->deta_puntos ?? 0);
                $this->model->builDetail->where('deta_id', $dataUsuEnc->rela_deta_id)->update(['deta_puntos' => $newPointMinus]);
            }
        }
        $this->dieMsg(true,[$dataDeta,$dataUsuEnc, $deta_id]);
    }

    public function finalizar($id)
    {
        $this->dieAjax();

        if (is_null($this->user->id)) return '';
        
        $this->model->builder->where(['encu_id' => $id, 'encu_usua_id' => $this->user->id])->update(['encu_finalizado' => true]);

        $this->dieMsg();
    }

    public function activar($id)
    {
        $this->dieAjax();

        if (is_null($this->user->id)) return '';

        $this->model->builder->where(['encu_id' => $id, 'encu_usua_id' => $this->user->id])->update(['encu_finalizado' => false]);

        $this->dieMsg();
    }

    public function test() {
    }
}
