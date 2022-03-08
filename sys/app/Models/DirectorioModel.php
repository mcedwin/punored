<?php 

namespace App\Models;

use CodeIgniter\Model;

class DirectorioModel extends Model
{
  protected $table = 'entrada';
  var $db;
  var $fields;
  protected $entr_tipo = 3;
  public function __construct()
  {
    parent::__construct();
      $this->db = \Config\Database::connect();
      $this->fields = array(
        'entr_tipo_id' => array('label' => 'Tipo de entrada', 'type' => 'hidden', 'required' => false),
        'entr_titulo' => array('label' => 'Titulo'),
        'entr_resumen' => array('label' => 'Resumen'),
        'entr_contenido' => array('label' => 'Contenido'),
        'entr_url' => array('label' => 'Pagina web de referencia', 'required' => false),
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
  function get($id = '')
    {
      $builderEntradaCate = $this->db->table('entrada_categoria');
    $this->fields['categorias'] = $builderEntradaCate->select('cate_id as `id`, cate_nombre as `text`')->get()->getResult();

    $builderEntrada = $this->db->table($this->table);
  
    if (!empty($id)) {
      $row = $builderEntrada->select()->where('entr_id', $id)->get()->getRow();
      foreach ($row as $k => $value) {
        if (!isset($this->fields[$k])) continue;
        $this->fields[$k]->value =  $value;
      }
    }
      return (object)$this->fields;
    }
  public function getDirectorioData($filters = [], $pag_size = 5, $offset = 0)
  {
    $builder = $this->getBuilder();
    $query = $builder->select([
        'entr_id',
        'entr_titulo',
        'entr_contenido',
        'entr_foto',
        'entr_url',
        'entr_fechapub',
        'entr_dire_logo',
        'entr_pmas',
        'entr_pmenos',
    ])
      ->select('usua_nombres')
      ->select('cate_nombre');
    $filter = $filters['filtro'] ?? 'recientes';
    if($filter == 'recientes'){
      $builder->orderBy('entr_fechapub', 'DESC');
    }
    else if($filter == 'antiguos'){
      $builder->orderBy('entr_fechapub', 'ASC');
    }
    else if ($filter == 'relevantes'){
      $builder->orderBy('entr_pmas', 'DESC');
    }
    $categoria = $filters['categoria'] ?? null;
    if($categoria){
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
        $builder->where('entr_fechapub <=', date('Y-m-d H:i:s'));
    }
    $builder
        ->select('usua_nombres')
        ->select('cate_nombre')
        ->join('usuario', 'usua_id = entr_usua_id', 'inner')
        ->join('entrada_categoria', 'entr_cate_id = cate_id', 'inner');
    if(!is_null($pag_size) && !is_null($offset))
        $builder->limit($pag_size, $offset);
    
    $query = $builder->get();
    $result = $query->getResultArray();
    return $result;
  }
  function countListado($filters = [])
  {
    $builder = $this->getBuilder();
    $fechaf = $filters['fechapub'] ?? true;
    if ($fechaf === true) {
        $builder->where('entr_fechapub <=', date('Y-m-d H:i:s'));
    }
    if (isset($filters['categoria'])) {
      $builder->where('entr_cate_id', $filters['categoria']);
    }
    if(isset($filters['user'])){
      $builder->where('entr_usua_id', $filters['user']);
    }
    $espublico = $filters['solo_publicos'] ?? true;
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
    $builderEntrada = $this->db->table($this->table);
    $builderEntrada->where('entr_id', $vdata['entr_id']);
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
        ->select('rela_nmas', 'rela_nmenos');
      $resultUsuaEntr = $builderUsuaEntr->get()->getRowArray();
      
      return array(
        'entr_id' => $entrId,
        'usua_id' => $usuaId,
        'pmas_entr' => $resultEntrada['entr_pmas'] ?? null,
        'pmenos_entr' => $resultEntrada['entr_pmenos'] ?? null,
        'nmas_rela' => $resultUsuaEntr['rela_nmas'] ?? null,
        'nmenos_rela' => $resultUsuaEntr['rela_nmenos'] ?? null,
      );
    }
}
