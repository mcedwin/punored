<?php

namespace App\Controllers;
use App\Models\EstuModel;

class Estudiante extends BaseController
{
    public function index($rowno = 0)
	{
        helper('formulario');
		$model = new EstuModel();
		$datos['id'] = '0';
		$datos['titulo'] = 'Registrar Estudiante';
		$datos['fields'] = $model->get();
        $this->addCss(array('lib/select2/dist/css/select2.min'));
		$this->addJs(array(
			"lib/tinymce/tinymce.min.js",
			"lib/tinymce/jquery.tinymce.min.js",

			'js/entrada/publicar.js'
		));

		$this->showHeader();
		$this->ShowContent('index', $datos);
		$this->showFooter();
	}
    public function guardar($id = '')
	{
        $Model_estu= new EstuModel();
		$data = $this->validar($this->$Model_entrada->getFields());
		$data['entr_fechareg'] = date('Y-m-d H:i:s');
		unset($data['usua_foto']);

		if (empty($id)) {
			$data['entr_usua_id'] = $this->mc_user->id;
			$this->db->insert('entrada', $data);
			$id = $this->db->insert_id();

			#$this->insertsubs($mirela, $id, 'empleo_idioma', 'idio_entr_id', 'idio_id');
			$path = 'img_' . $id . '.small.jpg';
			if ($this->guardar_imagen('uploads/entrada', $path)) {
				$this->db->update('entrada', array('entr_foto'=>$path), "entr_id='{$id}' AND entr_usua_id={$this->mc_user->id}");
			}

		} else {
			$path = 'img_' . $id . '.small.jpg';
			if ($this->guardar_imagen('uploads/entrada', $path)) {
				$data = $data + array('entr_foto' => $path);
			}
			$this->db->update('entrada', $data, "entr_id='{$id}' AND entr_usua_id={$this->mc_user->id}");
			#$this->updatesubs($mirela, $id, 'empleo_idioma', 'idio_entr_id', 'idio_id', $mirela_ids);
		}

		$this->dieMsg(true);
	}
    
}
