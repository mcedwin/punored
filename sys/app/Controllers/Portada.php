<?php

namespace App\Controllers;

use App\Models\EntradaModel;
use App\Models\UsuarioModel;

class Portada extends BaseController
{
    var $notiModel;
    var $anunModel;
    var $usuaModel;
    public function __construct()
    {
        $this->notiModel = new EntradaModel(1);
        $this->anunModel = new EntradaModel(2);
        $this->usuaModel = new UsuarioModel();
    }
    public function index()
	{
        $datos['miembros'] = $this->usuaModel->getUser('0',['usua_id', 'usua_nombres', 'usua_apellidos', 'usua_foto']);
        $datos['noticias'] = $this->notiModel->getBuilder()->limit(3)->orderBy('entr_pmas' , 'DESC')->get()->getResult();
		$datos['anuncios'] = $this->anunModel->getBuilder()->limit(3)->orderBy('entr_pmas' , 'DESC')->get()->getResult();
		$datos['comentarios'] = $this->db->query("SELECT * FROM comentario JOIN usuario ON usua_id=come_usua_id ORDER BY come_fechareg DESC LIMIT 3")->getResult();

		$this->addJs(array(
			"js/portada/publicar.js",
		));

		$this->showHeader();
		$this->showContent('index', $datos);
		$this->showFooter();
	}

	public function comentar()
	{
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
		$this->showHeader();
		$this->showContent('acerca');
		$this->showFooter();
	}

	public function crear()
	{
		$this->showHeader();
		$this->showContent('crear');
		$this->showFooter();
	}
}
