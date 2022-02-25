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
      'entr_id',
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
    } else if ($filter == 'antiguos') {
      $builder->orderBy('entr_fechapub', 'ASC');
    } else if ($filter == 'relevantes') {
      $builder->orderBy('entr_pmas', 'DESC');
    }

    $categoria = $filters['categoria'] ?? null;
    if ($categoria) {
      $builder->where('entr_cate_id', $categoria);
    }

    
    $builder->join('usuario', 'usua_id = entr_usua_id', 'left')
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

  public function insertPoint($vdata) {
    $builderEntrada = $this->db->table($this->table);
    $builderEntrada->where('entr_id', $vdata['entr_id']);
    $builderUsuaEntr = $this->getBuilderUsuaEntr($vdata['entr_id'], $vdata['usua_id']);
    
    //Getting last punctuations
    $lastDataEntrada = 0;
    $lastDataUsuaEntr = 0;
    if (isset($vdata['pmas'])) {
      $lastDataEntrada = $builderEntrada->select(['entr_pmas'])
        ->get()->getRowArray()['entr_pmas'];
      $lastDataUsuaEntr = $builderUsuaEntr->select(['rela_nmas'])
        ->get()->getRowArray()['rela_nmas'];
    }
    else if (isset($vdata['pmenos'])) {
      $lastDataEntrada = $builderEntrada->select(['entr_pmenos'])
        ->get()->getRowArray()['entr_pmenos'];
      $lastDataUsuaEntr = $builderUsuaEntr->select(['rela_nmenos'])
        ->get()->getRowArray()['rela_nmenos'];
    }
    else return [];
    if ($lastDataUsuaEntr >= 5) return [];
    //Add point to Entrada
    unset($builderEntrada);
    $builderEntrada = $this->getBuilder();
    $builderEntrada->where('entr_id', $vdata['entr_id']);
    if (isset($vdata['pmas'])) $builderEntrada->set(['entr_pmas' => (int)$lastDataEntrada + 1]);
    else $builderEntrada->set(['entr_pmenos' => (int)$lastDataEntrada + 1]);
    $builderEntrada->update();
    //Add point or create relation with point
    unset($builderUsuaEntr);
    if ($lastDataEntrada == null) { //no existe registro Usua_Entr
      $builderUsuaEntr = $this->db->table('usuario_entrada');
      $data = [
        'rela_usua_id' => $vdata['usua_id'],
        'rela_entr_id' => $vdata['entr_id'],
        'rela_like_id' => 0
      ];
      if (isset($vdata['pmas'])) {
        $data['rela_nmas'] = 1;
        $data['rela_nmenos'] = 0;
      }
      else {
        $data['rela_nmas'] = 0;
        $data['rela_nmenos'] = 1;
      }
      $builderUsuaEntr->insert($data);
    }
    else {//ya existe
      $builderUsuaEntr = $this->getBuilderUsuaEntr($vdata['entr_id'], $vdata['usua_id']);
      if (isset($vdata['pmas'])) $builderUsuaEntr->set(['rela_nmas' => (int)$lastDataUsuaEntr + 1]);
      else $builderUsuaEntr->set(['rela_nmenos' => (int)$lastDataUsuaEntr + 1]);
      $builderUsuaEntr->update();
    }
    return $this->db->affectedRows();
  }

  protected function getBuilderUsuaEntr($entrId, $usuaId) {
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
      ->select('rela_nmas', 'rela_nmenos');
    $resultUsuaEntr = $builderUsuaEntr->get()->getRowArray();
    
    return array(
      'entr_id' => $entrId,
      'usua_id' => $usuaId,
      'totalpmas_entr' => $resultEntrada['entr_pmas'] ?? null,
      'totalpmenos_entr' => $resultEntrada['entr_pmenos'] ?? null,
      'totalpmas_usua' => $resultUsuaEntr['rela_nmas'] ?? null,
      'totalpmenos_usua' => $resultUsuaEntr['rela_nmenos'] ?? null
    );
  }

  public function getLastPoints2()
  {
    $builderEntrada = $this->db->table($this->table);
    $builderEntrada->select('entr_id');
    $quant = $builderEntrada->countAllResults();
    $res = $builderEntrada->get()->getResult();
    return [$quant, $res];
  }
}