<?php

namespace App\Models;

use CodeIgniter\Model;

class PersonaModel extends Model
{
  var $db;
  var $fields;
  public function __construct()
  {
    parent::__construct();
    $this->db = \Config\Database::connect();

    $this->fields = array(
      'pers_nombre' => array('label' => 'Nombre'),
      'pers_email' => array('label' => 'Correo'),
      'pers_password' => array('label' => 'Contraseña')
    );

    $dfields = $this->db->getFieldData('persona');

    foreach ($dfields as $reg) {
      if (!isset($this->fields[$reg->name])) continue;
      $this->fields[$reg->name]['type'] = $this->fields[$reg->name]['type'] ?? $reg->type;
      $this->fields[$reg->name]['name'] = $this->fields[$reg->name]['name'] ?? $reg->name;
      $this->fields[$reg->name]['max_length'] = $reg->max_length;
      $this->fields[$reg->name]['value'] = $this->fields[$reg->name]['value'] ?? '';
      $this->fields[$reg->name]['required'] = $this->fields[$reg->name]['required'] ?? true;
      $this->fields[$reg->name] = (object)$this->fields[$reg->name];
    }
  }

  function getFields($type = 'all')
  {
    return $this->fields;
  }


  public function getTables()
  {
    return $this->tables = $this->db->listTables();
  }

  //Get fields data from personas table, by param
  public function getPersonas($fields = [''])
  {
    $sql = 'SELECT ';
    ///Select all fields
    foreach ($fields as $field) $sql .= " $field,";
    $sql[strlen($sql) - 1] = " ";
    $sql .= ' FROM persona ';

    $query = $this->db->query($sql);
    $results = $query->getResultArray();
    return $results;
  }
/*
  function getPerson($id = 0)
  {
    $sql = "SELECT pers_nombre, pers_email FROM persona WHERE pers_id = '{$id}'";
    $query = $this->db->query($sql);
    if( $query->getRow() === NULL) return [];
    $result = $query->getResultArray()[0];
    return $result;
  }
  */

  function saveData($data)
  {
    $this->db->table('persona')->insert($data);
  }

  function get($id = 0)
  {
    if (!empty($id)) {
      $row = $this->db->query("SELECT * FROM persona WHERE pers_id = $id")->getRow();
      foreach ($row as $k => $value) {
        if (!isset($this->fields[$k])) continue;
        $this->fields[$k]->value = $value;
      }
    }
    return (object)$this->fields;
  }
  public function getFldData()
  {
    return $this->db->query("SELECT * FROM persona WHERE pers_id = 1")->getFieldData();
  }
  public function getFlds()
  {
    return $this->fields;
  }
}
