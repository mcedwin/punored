<?php

namespace App\Controllers;

use App\Models\EncuestasModel;
use App\Models\EntradaModel;
use App\Models\UsuarioModel;

class Portada extends BaseController
{
    var $notiModel;
    var $anunModel;
    var $usuaModel;
    var $encuModel;
    public function __construct()
    {
        $this->notiModel = new EntradaModel(1);
        $this->anunModel = new EntradaModel(2);
        $this->usuaModel = new UsuarioModel();
        $this->encuModel = new EncuestasModel();
    }
    public function index()
	{
        $datos['miembros'] = $this->usuaModel->getUser('0', ['usua_id', 'usua_nombres', 'usua_apellidos', 'usua_foto']);
        $datos['noticias'] = $this->notiModel->getBuilder()->limit(3)->orderBy('entr_pmas' , 'DESC')->get()->getResult();
		$datos['anuncios'] = $this->anunModel->getBuilder()->limit(3)->orderBy('entr_pmas' , 'DESC')->get()->getResult();
		$datos['comentarios'] = $this->db->query("SELECT * FROM comentario JOIN usuario ON usua_id=come_usua_id ORDER BY come_fechareg DESC LIMIT 10")->getResult();
        $datos['encuesta'] = $this->encuModel->builder->select()->limit(1)->where('encu_actual', true)->get()->getRow();
        $datos['detalle'] = $this->encuModel->getEncuDetalle($datos['encuesta']->encu_id);


		$this->addJs(array(
			"js/portada/publicar.js",
            'js/encuesta/votar.js',
		));

		/** MAPA */
		$mapamodel = new EntradaModel(4);
		$data = ['from' => 'Mapa/index/'];
		$this->addCss(array(
			'lib/leaflet/leaflet.css'
		));
		$this->addJs(array(
			'lib/leaflet/leaflet.js',
			'js/mapa/mostrar.js',
		));
		$filter = $this->request->getGet('filtro') ?? 'recientes';
        $categ_id = $this->request->getGet('categoria') ?? null;
        $filters = ['filtro' => $filter, 'categoria' => $categ_id];
        $data['filtros'] = $filters;

		$query = $this->db->query("SELECT * FROM entrada WHERE entr_tipo_id = 4");
		$results = $query->getResult();

		$locPins=[];

		foreach($results as $value){
			$locPins[]=[
				"id" => $value->entr_id,
				"lat" => $value->entr_map_lat, 
				"lng" => $value->entr_map_lng,
				"titulo" => $value->entr_titulo,
				"resumen"=>$value->entr_resumen,
				"foto" => $value->entr_foto = base_url("uploads/mapa/" . $value->entr_foto),
				"pmas" => $value->entr_pmas,
				"pmenos" => $value->entr_pmenos,
			];
		}
		
		//var_dump(json_encode($locPins));
		$data['categorias'] = $mapamodel->getCategorias();
		$data['pathpts'] = base_url("mapa/setpunto");
		$data['pathsee'] = base_url("mapa/ver");
		// $data = ['data' = [
		// 	"pathpts" => base_url("mapa/setpunto"),

		// ]] 
		$data['locPins']= json_encode($locPins);
		/** FIN MAPA */

		$this->showHeader();
		$this->showContent('index', $datos+$data);
		$this->showFooter();
	}

	public function comentar()
	{
        $this->diePermiso($this->user->id);
		$mensaje = $this->request->getPost('mensaje');
		if (empty($mensaje)) $this->dieMsg(false, "Campo de mensaje es requerido.");

		$data = [
			'come_fechareg' => date('Y-m-d H:i:s'),
			'come_usua_id' => $this->user->id,
			'come_mensaje' => $mensaje
		];

		$this->db->table('comentario')->insert($data);

		$this->dieMsg(true, '', base_url('/'));
	}

	public function acerca()
	{
		$this->meta->title = "Acerca del Portal";
		$this->showHeader();
		$this->showContent('acerca');
		$this->showFooter();
	}
	
	public function publicar()
	{
		$this->showHeader();
		$this->showContent('crear');
		$this->showFooter();
	}
}
