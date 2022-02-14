<?php

namespace App\Controllers;
use App\Models\EntradaModel;

class Entrada extends BaseController
{
    public function index($rowno = 0)
	{
		$datos['categoria'] = (object)array(
			'name' => 'categoria',
			'label' => 'Categoría',
			'required' => false,
			'value' => '',
			'type' => 'select',
			'data' => $this->db->query("SELECT cate_id as id,cate_nombre as text FROM entrada_categoria")->getResult()
		);
		$datos['ubigeo'] = (object)array(
			'name' => 'ubigeo',
			'label' => 'Ubicación',
			'required' => false,
			'value' => '',
			'type' => 'select',
			'id' => '',
			'text' => '',
		);



		$this->addCss(array('lib/bootstrap-slider/css/bootstrap-slider.min', 'lib/select2/dist/css/select2.min'));
		$this->addJs(array(
			'lib/bootstrap-slider/bootstrap-slider.min.js',
			'lib/select2/dist/js/select2.js',
			'js/habilidad/scripts.js',
			'js/entrada/index.js',
		));
		$this->showHeader();
		$this->ShowContent('index', $datos);
		$this->showFooter();
	}

	public function anuncios($rowno = 0)
	{
		$this->showHeader();
		$this->ShowContent('anuncios');
		$this->showFooter();
	}

	public function ver($id)
	{
		$this->load->model('Model_entrada');
		$baseurl = base_url('uploads/entrada/');
		$base = base_url('Empleo/ver/');
		$datos = array(
			'reg' => $this->db->query("SELECT SQL_CALC_FOUND_ROWS 
			entr_id id,
			entr_titulo title,
			entr_usua_id as ide,
			usua_rsocial as rsocial,
			CONCAT('{$baseurl}',IF(entr_foto IS NULL,'sinlogo.png',entr_foto)) as foto,
			CONCAT('{$base}',entr_id) url,
			entr_descripcion description,
			entr_fechareg time,
			(SELECT GROUP_CONCAT(habi_nombre) FROM habilidad JOIN entrada_habilidad ON rela_habi_id=habi_id WHERE rela_entr_id=tr.entr_id) as skills,
			(SELECT CONCAT(ubig_departamento,' / ',ubig_provincia,' / ',ubig_distrito) FROM ubigeo WHERE ubig_id=tr.entr_ubig_id) as  ubicacion
			FROM entrada tr
			JOIN usuario ON usua_id=tr.entr_usua_id
			WHERE entr_id='{$id}'")->row()
		);

		/*$ide = $datos['reg']->entr_usua_id;
		$row = $this->db->query("SELECT * FROM usuario WHERE usua_id='{$ide}'")->row();
		$row->empr_foto = base_url('uploads/usuario') . (empty($row->empr_foto) ? '/sinlogo.png' : '/' . $row->empr_foto);*/
		//$datos['empr'] = $row;
		$this->showHeader();
		$this->ShowContent('ver', $datos);
		$this->showFooter();
	}

	public function crear()
	{
		helper("formulario");
		//$this->permitir_acceso();
		$this->addCss(array('lib/select2/dist/css/select2.min'));
		$this->addJs(array(
			"lib/tinymce/tinymce.min.js",
			"lib/tinymce/jquery.tinymce.min.js",
			//'lib/select2/dist/js/select2.js',
			'js/habilidad/scripts.js',
			//'js/Portada/empresa.js',
			'js/entrada/publicar.js'
		));

		$model = new EntradaModel();
		$datos['id'] = '0';
		$datos['titulo'] = 'Publicar noticia';
		$datos['fields'] = $model->get();

		$this->showHeader();
		$this->ShowContent('form', $datos);
		$this->showFooter();
	}

	public function anun_crear()
	{
		helper("formulario");
		//$this->permitir_acceso();
		$this->addCss(array('lib/select2/dist/css/select2.min'));
		$this->addJs(array(
			"lib/tinymce/tinymce.min.js",
			"lib/tinymce/jquery.tinymce.min.js",
			//'lib/select2/dist/js/select2.js',
			'js/habilidad/scripts.js',
			//'js/Portada/empresa.js',
			'js/entrada/publicar.js'
		));

		$model = new EntradaModel();
		$datos['id'] = '0';
		$datos['titulo'] = 'Publicar anuncio';
		$datos['fields'] = $model->get();

		$this->showHeader();
		$this->ShowContent('form', $datos);
		$this->showFooter();
	}

	public function dire_crear()
	{
		helper("formulario");
		//$this->permitir_acceso();
		$this->addCss(array('lib/select2/dist/css/select2.min'));
		$this->addJs(array(
			"lib/tinymce/tinymce.min.js",
			"lib/tinymce/jquery.tinymce.min.js",
			//'lib/select2/dist/js/select2.js',
			'js/habilidad/scripts.js',
			//'js/Portada/empresa.js',
			'js/entrada/publicar.js'
		));

		$model = new EntradaModel();
		$datos['id'] = '0';
		$datos['titulo'] = 'Publicar en directorio';
		$datos['fields'] = $model->get();

		$this->showHeader();
		$this->ShowContent('form', $datos);
		$this->showFooter();
	}


	public function editar($id)
	{
		$this->addCss(array('lib/select2/dist/css/select2.min'));
		$this->addJs(array(
			"lib/tinymce/tinymce.min.js",
			"lib/tinymce/jquery.tinymce.min.js",
			'lib/select2/dist/js/select2.js',
			'js/habilidad/scripts.js',
			//'js/Portada/empresa.js',
			'js/entrada/publicar.js'
		));

		$this->load->model('Model_entrada');
		$datos['id'] = $id;
		$datos['titulo'] = 'Editar noticia';
		$datos['fields'] = $this->Model_entrada->get($id);
		$datos['fields']->entr_foto->value = base_url('uploads/entrada') . (empty($datos['fields']->entr_foto->value) ? '/sinlogo.png' : '/' . $datos['fields']->entr_foto->value);
		//$datos['fields']->entr_descripcion->value = 

		$this->showHeader();
		$this->ShowContent('form', $datos);
		$this->showFooter();
	}

	public function guardar($id = '')
	{
		$this->load->model('Model_entrada');
		$data = $this->validar($this->Model_entrada->getFields());
		$data['entr_fechareg'] = date('Y-m-d H:i:s');
		unset($data['usua_foto']);

		list($mirela, $mirela_ids) = $this->getposts('empleo_idioma', 'mirela', 'idio_id', 'idio_tipo_id');

		if (empty($id)) {
			$data['entr_usua_id'] = $this->mc_user->id;
			$this->db->insert('entrada', $data);
			$id = $this->db->insert_id();

			$this->insertsubs($mirela, $id, 'empleo_idioma', 'idio_entr_id', 'idio_id');
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
			$this->updatesubs($mirela, $id, 'empleo_idioma', 'idio_entr_id', 'idio_id', $mirela_ids);
		}


		/** habilidades */
		$ids = $this->input->post('mihabi');
		$imps = '0';
		if (isset($ids['rid'])) {
			$r = array();
			foreach ($ids['rid'] as $i => $item) {
				if (!empty($item)) $r[] = $item;
			}
			$imps = count($r) > 0 ? implode(",", $r) : '0';
		}
		$this->db->query("DELETE FROM entrada_habilidad WHERE rela_id NOT IN($imps) AND rela_entr_id='{$id}'");
		if (isset($ids['hid']))
			foreach ($ids['hid'] as $i => $item) {
				$data = array(
					'rela_entr_id' => $id,
					'rela_habi_id' => $item,
				);
				if (empty($ids['rid'][$i])) $this->db->insert('entrada_habilidad', $data);
			}


		$this->dieMsg(true);
	}

	public function eliminar($id)
	{
		$this->dieAjax();
		$this->db->query("DELETE FROM entrada WHERE entr_id='{$id}' AND entr_usua_id='{$this->mc_user->id}'");
		$this->dieMsg();
	}

	public function misregistros($rowno = 0)
	{
		$this->permitir_acceso();
		if ($this->isAjax()) {
			$baseupload = base_url('uploads/entrada/');
			$base = base_url('entrada/ver/');
			$sql = "SELECT SQL_CALC_FOUND_ROWS 
						entr_id id,
						entr_titulo title,
						SUBSTRING(entr_descripcion,1,255) as description,
						entr_fechareg time,
						CONCAT('{$baseupload}',entr_foto) foto,
						CONCAT('{$base}',entr_id) url,
						(SELECT GROUP_CONCAT(habi_nombre) FROM habilidad JOIN entrada_habilidad ON rela_habi_id=habi_id WHERE rela_entr_id=tr.entr_id) as skills,
						(SELECT cate_nombre FROM entrada_categoria WHERE cate_id=tr.entr_cate_id) as categoria
						FROM (SELECT * FROM entrada WHERE entr_usua_id='{$this->mc_user->id}') as tr
						JOIN usuario ON usua_id=entr_usua_id AND tr.entr_cate_id!=3
						ORDER BY entr_id DESC";
			die($this->getPagination($sql, 5, $rowno));
		}

		$this->addCss(array('lib/select2/dist/css/select2.min'));
		$this->addJs(array('lib/select2/dist/js/select2.js', 'js/entrada/misregistros.js'));

		$this->showHeader();
		$this->ShowContent('misregistros');
		$this->showFooter();
	}
}
