<?php 

namespace App\Models;
 
use CodeIgniter\Model;

class EntradaModel extends Model
{
    var $fields;
  public function __construct()
  {
    parent::__construct();
    $this->fields = array(
      'entr_titulo' => array('label' => 'Titulo'),
      'entr_descripcion' => array('label' => 'Descripción'),
      #'entr_ubig_id' => array('label' => 'Ubicación', 'required' => false),
      'entr_url' => array('label' => 'Pagina web de referencia', 'required' => false),
      #'entr_empl_remu_id' => array('label' => 'Remuneración'),
      'entr_foto' => array('label' => 'Imagen','required' => false),
      #'entr_empl_cont_id' => array('label' => 'Contrato'),
      #'entr_empl_hora_id' => array('label' => 'Horario', 'required' => false),
      'entr_cate_id' => array('label' => 'Categoria'),
    );

    $dfields = $this->db->getFieldData('entrada');

    foreach ($dfields as $reg) {
      if (!isset($this->fields[$reg->name])) continue;
      $this->fields[$reg->name]['type'] = isset($this->fields[$reg->name]['type']) ? $this->fields[$reg->name]['type'] : $reg->type;
      $this->fields[$reg->name]['name'] = isset($this->fields[$reg->name]['name']) ? $this->fields[$reg->name]['name'] : $reg->name;
      $this->fields[$reg->name]['max_length'] = $reg->max_length;
      $this->fields[$reg->name]['value'] =  isset($this->fields[$reg->name]['value']) ? $this->fields[$reg->name]['value'] : '';
      $this->fields[$reg->name]['required'] =  isset($this->fields[$reg->name]['required']) ? $this->fields[$reg->name]['required'] : true;
      $this->fields[$reg->name] = (object) $this->fields[$reg->name];
    }
  }

  function getFields($type = 'all')
  {
    return $this->fields;
  }

  function get($id = '')
  {

    $this->fields['categorias'] = $this->db->query("SELECT cate_id as id,cate_nombre as text FROM entrada_categoria WHERE cate_id!=3")->getResult();
  


    $this->fields['rela_id'] = (object)array(
      'name' => 'mirela[idio_id][]',
      'label' => '',
      'required' => false,
      'value' => '',
      'type' => 'hidden',
    );

    $this->fields['rela_idioma'] = (object)array(
      'name' => 'mirela[idio_tipo_id][]',
      'label' => '',
      'required' => true,
      'value' => '',
      'type' => 'select',
    );
    $this->fields['rela_nivel'] = (object)array(
      'name' => 'mirela[idio_nivel][]',
      'label' => '',
      'required' => true,
      'value' => '',
      'type' => 'select',
    );


    if (!empty($id)) {
      $row = $this->db->query("SELECT * FROM entrada WHERE entr_id='{$id}'")->getRow();
      foreach ($row as $k => $value) {
        if (!isset($this->fields[$k])) continue;
        $this->fields[$k]->value =  $value;
      }
      if (!empty($this->fields['entr_ubig_id']->value)) $this->fields['ubigeo'] = $this->db->query("SELECT ubig_id as id,CONCAT(ubig_departamento,' / ',ubig_provincia,' / ',ubig_distrito) as text FROM ubigeo WHERE ubig_id=" . $this->fields['entr_ubig_id']->value . "")->row();
      $this->fields['habilidades'] = $this->db->query("SELECT rela_id as rid, rela_habi_id as hid, habi_nombre as text
      FROM entrada_habilidad JOIN habilidad ON rela_habi_id=habi_id AND rela_entr_id='{$id}' ORDER BY rela_id ASC")->getResult();
      $this->fields['idiomas'] = $this->db->query("SELECT idio_id as rid, idio_tipo_id as hid, idio_nivel as niv
      FROM empleo_idioma WHERE idio_entr_id='{$id}' ORDER BY idio_id ASC")->getResult();
    }
    return (object)$this->fields;
  }

}
