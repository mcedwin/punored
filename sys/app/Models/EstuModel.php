<?php 

namespace App\Models;
 
use CodeIgniter\Model;

class EstuModel extends Model
{
    var $db;
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
  public function getEstudiantes($fields = [''])
  {
    $sql = 'SELECT ';
    ///Select all fields
    foreach ($fields as $field) $sql .= " $field,";
    $sql[strlen($sql) - 1] = " ";
    $sql .= ' FROM estudiante ';

    $query = $this->db->query($sql);
    $results = $query->getResultArray();
    return $results;
  }
  function get($id = 0)
  {
    if (!empty($id)) {
      $row = $this->db->query("SELECT * FROM estudiante WHERE est_id = $id")->getRow();
      foreach ($row as $k => $value) {
        if (!isset($this->fields[$k])) continue;
        $this->fields[$k]->value = $value;
      }
    }
    return (object)$this->fields;
  }
  function saveData($data)
  {
    $this->db->table('estudiante')->insert($data);
  }
  

}
