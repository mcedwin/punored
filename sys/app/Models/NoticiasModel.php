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

  public function getDataListado($filters = [], $pag_size = 5, $offset = 0)
  {
    
    
    $builder = $this->getBuilder();
    $builder->select([
      'entr_id',
      'entr_titulo',
      'entr_contenido',
      'entr_foto',
      'entr_url',
      'entr_fechapub',
      'entr_fechaven'
    ])
      ->select('usua_nombres');
    // ✅TODO filrado
    $filter = $filters['filtro'] ?? 'recientes';
    if ($filter == 'recientes') {
      $builder->orderBy('entr_fechapub', 'DESC');
    } else if ($filter == 'antiguos') {
      $builder->orderBy('entr_fechapub', 'ASC');
    } else if ($filter == 'relevantes') {
      $builder->orderBy('entr_pmas', 'DESC');
    }

    $categoria = $filters['categoria'] ?? null;
    if ($categoria) {
      $builder->where('entr_cate_id', $categoria);
    }
    
    if (isset($filters['user'])) {
      $builder->where('entr_usua_id', $filters['user']);
    }

    $espublico = $filters['espublico'] ?? true;
    if ($espublico === true) {
        $builder->where('entr_espublico', 1);
    }

    $fechaf = $filters['fecha'] ?? true;
    if ($fechaf === true) {
        $builder->where('entr_fechapub <=', date('Y-m-d H:i:s'))
            ->where('entr_fechaven >', date('Y-m-d H:i:s'));
    }

    $builder->join('usuario', 'usua_id = entr_usua_id', 'left')
      ->limit($pag_size, $offset);

    $query = $builder->get();
    die($this->db->getLastQuery());
    $result = $query->getResultArray();
    return $result;
  }

  function countListado($filters = [])
  {
    $builder = $this->getBuilder();
    $fechaf = $filters['fecha'] ?? true;
    if ($fechaf === true) {
        $builder->where('entr_fechapub <=', date('Y-m-d H:i:s'))
            ->where('entr_fechaven >', date('Y-m-d H:i:s'));
    }
    if (isset($filters['categoria'])) {
      $builder->where('entr_cate_id', $filters['categoria']);
    }
    if(isset($filters['user'])){
      $builder->where('entr_usua_id', $filters['user']);
    }
    $espublico = $filters['espublico'] ?? true;
    if ($espublico === true) {
        $builder->where('entr_espublico', 1);
    }
    return $builder->countAllResults();
  }

  public function getBuilder() {
    $builder = $this->db->table($this->table);
    $builder->where('entr_tipo_id', $this->entr_tipo);
    return $builder;
  }

  public function insertPoint($vdata) {
    $builderEntrada = $this->db->table('entrada');
    $builderEntrada->where('entr_id', $vdata['entr_id']);
    // $builderEntrada = $this->getBuilder()->where('entr_id', $vdata['entr_id']);
    $resultEntrada = $builderEntrada->select(['entr_pmas', 'entr_pmenos'])->get()->getRowArray();
    
    $builderUsuaEntr = $this->getBuilderUsuaEntr($vdata['entr_id'], $vdata['usua_id']);
    $resultUsuaEntr = $builderUsuaEntr->select(['rela_nmas', 'rela_nmenos'])->get()->getRowArray();
    //Getting last punctuations
    $lastDataEntrada = 0;
    $lastDataUsuaEntr = 0;
    if($resultUsuaEntr != null){
      if (isset($vdata['pmas'])) {
        $lastDataEntrada = $resultEntrada['entr_pmas'];
        $lastDataUsuaEntr = $resultUsuaEntr['rela_nmas'];
      }
      else if (isset($vdata['pmenos'])) {
        $lastDataEntrada = $resultEntrada['entr_pmenos'];
        $lastDataUsuaEntr = $resultUsuaEntr['rela_nmenos'];
      }
      else return -1;
    }
    if ($lastDataUsuaEntr >= 5) return -1;
    //Add point to Entrada
    
    $builderEntrada2 = $this->db->table($this->table);
    $builderEntrada2->where('entr_id', $vdata['entr_id']);
    if (isset($vdata['pmas'])) $builderEntrada2->set(['entr_pmas' => (int)$lastDataEntrada + 1]);
    else if (isset($vdata['pmenos'])) $builderEntrada2->set(['entr_pmenos' => (int)$lastDataEntrada + 1]);
    $builderEntrada2->update();
    //Add point or create relation with point
    
    if ($resultUsuaEntr == null) { //no existe registro Usua_Entr
      $builderUsuaEntr2 = $this->db->table('usuario_entrada');
      $data = [
        'rela_usua_id' => $vdata['usua_id'],
        'rela_entr_id' => $vdata['entr_id'],
        'rela_like' => 0,
        'rela_nmas' => 0,
        'rela_nmenos' => 0
      ];
      if (isset($vdata['pmas'])) $data['rela_nmas'] = 1;
      else if (isset($vdata['pmenos'])) $data['rela_nmenos'] = 1;
      $builderUsuaEntr2->insert($data);
    }
    else {//ya existe
      $builderUsuaEntr2 = $this->getBuilderUsuaEntr($vdata['entr_id'], $vdata['usua_id']);
      if (isset($vdata['pmas'])) $builderUsuaEntr2->set(['rela_nmas' => (int)$lastDataUsuaEntr + 1]);
      else $builderUsuaEntr2->set(['rela_nmenos' => (int)$lastDataUsuaEntr + 1]);
      $builderUsuaEntr2->update();
    }
    return $this->db->affectedRows();
  }

  public function getBuilderUsuaEntr($entrId, $usuaId) {
    $builderUsuaEntr = $this->db->table('usuario_entrada');
    $builderUsuaEntr
      ->where('rela_entr_id', $entrId)
      ->where('rela_usua_id', $usuaId);
    return $builderUsuaEntr;
  }
  
  public function getPoints($entrId, $usuaId) {
    $builderEntrada = $this->db->table($this->table);
    $builderUsuaEntr = $this->getBuilderUsuaEntr($entrId, $usuaId);

    $builderEntrada
      ->select('entr_pmas, entr_pmenos')
      ->where('entr_id', $entrId);
    $resultEntrada = $builderEntrada->get()->getRowArray();
    $builderUsuaEntr
      ->select(['rela_nmas', 'rela_nmenos']);
    $resultUsuaEntr = $builderUsuaEntr->get()->getRowArray();
    
    return array(
      'entr_id' => $entrId,
      'usua_id' => $usuaId,
      'totalpmas_entr' => $resultEntrada['entr_pmas'] ?? null,
      'totalpmenos_entr' => $resultEntrada['entr_pmenos'] ?? null,
      'totalpmas_usua' => $resultUsuaEntr['rela_nmas'] ?? null,
      'totalpmenos_usua' => $resultUsuaEntr['rela_nmenos'] ?? null,
    );
  }

  public function getLastPoints2()
  {
    $builderUsuaEntr = $this->getBuilderUsuaEntr(3, 7);
    $lastDataUsuaEntr = $builderUsuaEntr->select(['rela_nmas','rela_nmenos'])
    ->get()->getRowArray();
    return $lastDataUsuaEntr;
  }
}