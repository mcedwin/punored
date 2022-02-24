<?php 

namespace App\Models;
 
use CodeIgniter\Model;

class EntradaModel extends Model
{
  protected $table = 'entrada';

  var $fields;
  public function __construct()
  {
    parent::__construct();
    $this->fields = array(
      'entr_tipo_id' => array('label' => 'Tipo de entrada', 'type' => 'hidden', 'required' => false),
      'entr_titulo' => array('label' => 'Titulo'),
      'entr_contenido' => array('label' => 'Descripción'),
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
    $builderEntradaCate = $this->db->table('entrada_categoria');
    $this->fields['categorias'] = $builderEntradaCate->select('cate_id as `id`, cate_nombre as `text`')->get()->getResult();

    $builderEntrada = $this->db->table($this->table);
  
    if (!empty($id)) {
      $row = $builderEntrada->select()->where('entr_id', $id)->get()->getRow();
      foreach ($row as $k => $value) {
        if (!isset($this->fields[$k])) continue;
        $this->fields[$k]->value =  $value;
      }
    }
    return (object)$this->fields;
  }

}
