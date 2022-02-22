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

    public function getDataListaNoticia(){
      $builder = $this->db->table($this->table);
      $result = $builder->select([
      'entr_descripcion',
      'entr_foto',
      'entr_url',
      'entr_fechapub'
      ])
        ->select('usua_nombres')
        ->join('usuario','usua_id = entr_usua_id','left')
      ->get()->getResultArray();
      return $result;
    }
}