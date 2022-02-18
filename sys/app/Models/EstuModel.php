<?php 

namespace App\Models;
 
use CodeIgniter\Model;

class EstuModel extends Model
{
    var $fields;
  public function __construct()
  {
    parent::__construct();
    $this->db = \Config\Database::connect();

    $this->fields = array(  
      'est_nombre' => array('label' => 'Nombre'),
      'est_apellido' => array('label' => 'Apellido'),
      'est_edad' => array('label' => 'Edad')
    );
    $dfields = $this->db->getFieldData('estudiante');

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
    $this->fields['estudiante'] = $this->db->query("SELECT est_id as id,est_nombre as text FROM estudiante WHERE est_id !=1")->getResult();
    if (!empty($id)) {
      $row = $this->db->query("SELECT * FROM estudiante WHERE est_id='{$id}'")->row();
      foreach ($row as $k => $value) {
        if (!isset($this->fields[$k])) continue;
        $this->fields[$k]->value =  $value;
      }
    }
    return (object)$this->fields;
  }
  function Savedata($data)
  {
    $sql = 'INSERT INTO estudiante(est_nombre, est_apellido, est_edad) VALUES';
    $sql .= $data['est_nombre'];
    $sql .= $data['est_apellido'];
    $sql .= $data['est_edad'];
    $sql .= 'FROM estudiante';

    $this->db->table('estudiante')->insert($data);
  }

}
