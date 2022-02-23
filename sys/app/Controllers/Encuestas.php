<?php

namespace App\Controllers;
use App\Models\EntradaModel;

class Encuestas extends BaseController
{
    public function index($rowno = 0)
	{
		$sql = "SELECT * FROM encuesta WHERE encu_actual=true LIMIT 1";
		$datos['encuesta'] = $row = $this->db->query($sql)->getRow();
		$datos['detalle'] = $this->db->query("SELECT * FROM encuesta_detalle WHERE deta_encu_id='{$row->encu_id}'")->getResult();


		$this->addJs(array(
			'js/encuesta/votar.js'
		));
		$this->showHeader();
		$this->ShowContent('index',$datos);
		$this->showFooter();
	}

	public function crear(){
		$this->showHeader();
		$this->ShowContent('index');
		$this->showFooter();
	}
}
