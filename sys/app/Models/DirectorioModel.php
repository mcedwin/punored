<?php 

namespace App\Models;

use CodeIgniter\Model;

class DirectorioModel extends Model
{
  protected $table = 'entrada';
  var $db;
  var $fields;
  public $pager= '';
  public function __construct()
  {
    parent::__construct();
    $this->db = \Config\Database::connect();
    $this->pager = \Config\Services::pager();

    $this->fields = array(
      'entr_titulo' => array('label' => 'Titulo'),
      'entr_resumen' => array('label' => 'Resumen'),
      'entr_contenido' => array('label' => 'Contenido'),
      'entr_dire_logo' => array('label' => 'Logo'),
      'entr_foto' => array('label' => 'Imagen'),
      'entr_cate_id' => array('label' => 'Categoria'),
    );
  
    $dfields = $this->db->getFieldData($this->table);
  
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
  function saveData($data)
  {
    $this->db->table($this->table)->insert($data);
  }
  
  function get($id = 0)
    {
      $this->fields['categorias'] = $this->db->query("SELECT cate_id as id, cate_nombre as text FROM entrada_categoria WHERE cate_tipo_id = 3")->getResult();
      if (!empty($id)) {
        $row = $this->db->query("SELECT * FROM entrada WHERE cate_id = $id")->getRow();
        foreach ($row as $k => $value) {
          if (!isset($this->fields[$k])) continue;
          $this->fields[$k]->value = $value;
        }
      }
      return (object)$this->fields;
    }
  public function getDirectorioData($pag_size = 5, $offset = 0){
    $builder = $this->db->table($this->table);
    $query = $builder->select([
        'entr_titulo',
        'entr_resumen',
        'entr_foto',
        'entr_dire_logo',
      ])->limit($pag_size, $offset);
    $result = $query->get()->getResultArray();
    return $result;
  }
  public function count()
  {
    $builder = $this->db->table($this->table);
    return $builder->countAll();
  }
}
