<?php

namespace App\Models;

use CodeIgniter\Model;

class NoticiasModel extends Model
{
  protected $table = 'entrada';

  public $pager = '';
  public function __construct()
  {
    parent::__construct();
    $this->pager = \Config\Services::pager();
  }

  public function getDataListado($pag_size = 5, $offset = 0)
  {
    $builder = $this->db->table($this->table);
    $query = $builder->select([
        'entr_descripcion',
        'entr_foto',
        'entr_url',
        'entr_fechapub'
      ])
        ->select('usua_nombres')
        ->join('usuario','usua_id = entr_usua_id','left')
      ->limit($pag_size, $offset);
    $result = $query->get()->getResultArray();
    return $result;
  }

  function count()
  {
    $builder = $this->db->table($this->table);
    return $builder->countAll();
  }
}