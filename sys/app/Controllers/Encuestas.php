<?php

namespace App\Controllers;

use App\Models\EncuestasModel;
use App\Models\EntradaModel;

class Encuestas extends BaseController
{
    public function index($rowno = 0)
	{
		// $sql = "SELECT * FROM encuesta WHERE encu_actual=true LIMIT 1";
		// $this->datos['encuesta'] = $row = $this->db->query($sql)->getRow();
		// $this->datos['detalle'] = $this->db->query("SELECT * FROM encuesta_detalle WHERE deta_encu_id='{$row->encu_id}'")->getResult();
        $model = new EncuestasModel();
        $this->datos['encuesta'] = $row = $model->getEncuesta(1);
        $this->datos['detalle'] = $model->getEncuDetalle($row->encu_id);

		$this->addJs(array(
			'js/encuesta/votar.js'
		));
		$this->showHeader();
		$this->ShowContent('index');
		$this->showFooter();
	}

	public function misencuestas(){
		$this->showHeader();
		$this->ShowContent('misencuestas');
		$this->showFooter();
	}

	public function crear(){
		$this->showHeader();
		$this->ShowContent('index');
		$this->showFooter();
	}
    public function test() {
        $model = new EncuestasModel();
        $data = [];
        // $data += $row = $model->getEncuesta(1);
        // $data += $model->getEncuestaDetalle($row->encu_id);
        echo '<pre>'; var_dump($data); echo '</pre>';
    }
}
