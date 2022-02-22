<?php

namespace App\Models;

use CodeIgniter\Model;

class NoticiasModel extends Model
{
  protected $table = 'entrada';

  public function __construct()
  {
    parent::__construct();
  }

  public function getDataListado($pag_size = 5, $offset = 0){
    // if( $offset*$pag_size < $this->count() ) return redirect()->to(base_url('Noticias'));
    $builder = $this->db->table($this->table);
    $result = $builder->select([
        'entr_descripcion',
        'entr_foto',
        'entr_url',
        'entr_fechapub'
      ])
        ->select('usua_nombres')
        ->join('usuario','usua_id = entr_usua_id','left')
      ->limit($pag_size, $offset)
    ->get()->getResultArray();
    return $result;
  }

  function count()
  {
    $builder = $this->db->table($this->table);
    return $builder->countAll();
  }
}