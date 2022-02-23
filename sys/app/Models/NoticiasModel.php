<?php

namespace App\Models;

use CodeIgniter\Model;

class NoticiasModel extends Model
{
  protected $table = 'entrada';
  
  protected $entr_tipo = 1;
  public function __construct()
  {
    parent::__construct();
  }

  public function getDataListado($filters = ['filtro' => 'recientes'], $pag_size = 5, $offset = 0)
  {
    $builder = $this->getBuilder();
    $builder->select([
        'entr_contenido',
        'entr_foto',
        'entr_url',
        'entr_fechapub'
    ])
      ->select('usua_nombres');
    // ✅TODO filrado
    $filter = $filters['filtro'] ?? 'recientes';
    if ($filter == 'recientes') {
      $builder->orderBy('entr_fechapub', 'DESC');
    }
    else if ($filter == 'antiguos') {
      $builder->orderBy('entr_fechapub', 'ASC');
    }
    else if ($filter == 'relevantes') {
      $builder->orderBy('entr_pmas', 'DESC');
    }

    $categoria = $filters['categoria'] ?? null;
    if ($categoria) {
      $builder->where('entr_cate_id', $categoria);
    }

    
    $builder->join('usuario','usua_id = entr_usua_id','left')
    ->limit($pag_size, $offset);

    $query = $builder->get();
    $result = $query->getResultArray();
    return $result;
  }

  function countListado($filters = [])
  {
    $builder = $this->getBuilder();
    if (isset($filters['categoria'])) {
      $builder->where('entr_cate_id', $filters['categoria']);
    }
    return $builder->countAllResults();
  }

  public function getBuilder() {
    $builder = $this->db->table($this->table);
    $builder->where('entr_tipo_id', $this->entr_tipo);
    return $builder;
  }
}