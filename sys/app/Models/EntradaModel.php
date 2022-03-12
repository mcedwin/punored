<?php

namespace App\Models;

use CodeIgniter\Model;

class EntradaModel extends Model
{
  protected $table = 'entrada';
  protected $tabUsuEntr = 'usuario_entrada';
  protected $entr_tipo = 1;

  public $builder;
  public $builUsuEntr;
  var $fields;

  public function __construct($tipo)
  {
    parent::__construct();

    $this->entr_tipo = $tipo;
    $this->builder = $this->db->table($this->table);
    $this->builUsuEntr = $this->db->table($this->tabUsuEntr);

    if ($this->entr_tipo == 1) {
      $this->fields = array(
        'entr_tipo_id' => array('label' => 'Tipo de entrada', 'type' => 'hidden', 'required' => false),
        'entr_titulo' => array('label' => 'Titulo'),
        'entr_contenido' => array('label' => 'Descripción'),
        'entr_url' => array('label' => 'Pagina web de referencia', 'required' => false),
        'entr_foto' => array('label' => 'Imagen', 'required' => false),
        'entr_cate_id' => array('label' => 'Categoria'),
      );
    } else if ($this->entr_tipo == 2) {
      $this->fields = array(
        'entr_tipo_id' => array('label' => 'Tipo de entrada', 'type' => 'hidden', 'required' => false),
        'entr_titulo' => array('label' => 'Titulo'),
        'entr_contenido' => array('label' => 'Descripción'),
        'entr_url' => array('label' => 'Pagina web de referencia', 'required' => false),
        'entr_foto' => array('label' => 'Imagen', 'required' => false),
        'entr_fechaven' => array('label' => 'Fecha Vencimiento'),
        'entr_cate_id' => array('label' => 'Categoria'),
      );
    } else if ($this->entr_tipo == 3) {

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
    }

    helper('funciones');
    $dfields = $this->db->getFieldData('entrada');
    iniFields($dfields, $this->fields);
  }

  function getFields()
  {
    return $this->fields;
  }

  function get($id = '')
  {
    $builderEntradaCate = $this->db->table('entrada_categoria');
        $this->fields['categorias'] = $builderEntradaCate->select('cate_id as `id`, cate_nombre as `text`')->where('cate_tipo_id',$this->entr_tipo)->get()->getResult();

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

  public function getEntrada($id, $fields = '*')
  {
    return $this->getBuilder()->where('entr_id', $id)->select($fields)->get()->getRow();
  }

  public function getDataListado($filters = [], $pag_size = null, $offset = null)
  {


    $builder = $this->getBuilder();
    $builder->select([
      'entr_id',
      'entr_titulo',
      'entr_contenido',
      'entr_foto',
      'entr_url',
      'entr_fechapub',
      'entr_pmas',
      'entr_pmenos',
    ]);
    $filter = $filters['filtro'] ?? 'recientes';
    if ($filter == 'recientes') {
      $builder->orderBy('entr_fechapub', 'DESC');
    } else if ($filter == 'antiguos') {
      $builder->orderBy('entr_fechapub', 'ASC');
    } else if ($filter == 'relevantes') {
      $builder->orderBy('entr_pmas', 'DESC');
    }

    if (isset($filters['categoria'])) {
      $builder->where('entr_cate_id', $filters['categoria']);
    }

    if (isset($filters['user'])) {
      $builder->where('entr_usua_id', $filters['user']);
    }

    if ($filters['solo_publicos'] ?? true) {
      $builder->where('entr_espublico', true);
    }

    if ($filters['fechapub'] ?? true) {
      $builder->where('entr_fechapub <=', date('Y-m-d H:i:s'));
    }

    $builder->select(['usua_nombres','cate_nombre'])
      ->join('usuario', 'usua_id = entr_usua_id', 'inner') //inner
      ->join('entrada_categoria', 'entr_cate_id = cate_id', 'inner');

    if (!is_null($pag_size) && !is_null($offset))
      $builder->limit($pag_size, $offset);

    return $builder->get()->getResultArray();
  }

  function countListado($filters = [])
  {
    $builder = $this->getBuilder();
    if ($filters['fechapub'] ?? true) {
      $builder->where('entr_fechapub <=', date('Y-m-d H:i:s'));
    }
    if (isset($filters['categoria'])) {
      $builder->where('entr_cate_id', $filters['categoria']);
    }
    if (isset($filters['user'])) {
      $builder->where('entr_usua_id', $filters['user']);
    }
    if ($filters['solo_publicos'] ?? true) {
      $builder->where('entr_espublico', true);
    }
    return $builder->countAllResults();
  }

  public function getBuilder()
  {
    $builder = $this->db->table($this->table);
    $builder->where('entr_tipo_id', $this->entr_tipo);
    return $builder;
  }

  public function insertPoint($vdata)
  {
    if ($vdata->punto != 'mas' && $vdata->punto != 'menos') return -1;
    //determine existency of usua_entrada
    $dataUsuaEntr = $this->getBuilderUsuaEntr($vdata->entr_id, $vdata->usua_id)->select()->get()->getRow();
    $fieldPoint = ($vdata->punto == 'mas')? 'entr_pmas': 'entr_pmenos';
    if ($dataUsuaEntr == null) {//if doesn't exist relation, create usua_entrada register(db) and put 1 point more at the entrada(db)
      //creating relation
      $data['rela_entr_id'] = $vdata->entr_id;
      $data['rela_usua_id'] = $vdata->usua_id;
      $data['rela_nmas'] = ($vdata->punto == 'mas') ? 1 : 0;//? true : false;
      $data['rela_nmenos'] = ($vdata->punto == 'menos') ? 1 : 0;//? true : false;
      $data['rela_like'] = false;
      $data['rela_fechareg'] = date('Y-m-d H:i:s');

      $this->builUsuEntr->insert($data);
      //Adding point
      $newPoints = 1 + (int)($this->getBuilder()->select($fieldPoint)->where('entr_id', $vdata->entr_id)->get()->getRowArray()[$fieldPoint]);
      $this->getBuilder()->where('entr_id', $vdata->entr_id)->set($fieldPoint, $newPoints)->update();
    } else {//if exist point(mas or menos) just can modify by his counter(mas by menos, or menos by mas)
    //and put 1 point more o r 1 point minus at the same time
      $relaFieldPoint = ($vdata->punto == 'mas') ? 'rela_nmas' : 'rela_nmenos';
      if ($dataUsuaEntr->rela_nmas == 0 && $dataUsuaEntr->rela_nmenos == 0) {
        $this->getBuilderUsuaEntr($vdata->entr_id, $vdata->usua_id)->update([
          'rela_nmas' => ($vdata->punto == 'mas') ? 1 : 0,
          'rela_nmenos' => ($vdata->punto == 'menos') ? 1 : 0,
        ]);
        $newPoints = 1 + (int)($this->getBuilder()->select($fieldPoint)->where('entr_id', $vdata->entr_id)->get()->getRowArray()[$fieldPoint]);
        $this->getBuilder()->where('entr_id', $vdata->entr_id)->set($fieldPoint, $newPoints)->update();
      }
      else if ($dataUsuaEntr->rela_nmas == 1 && $dataUsuaEntr->rela_nmenos == 0) {
        if ($vdata->punto == 'menos') {
          $this->getBuilderUsuaEntr($vdata->entr_id, $vdata->usua_id)->update(['rela_nmas' => 0, 'rela_nmenos' => 1]);

          $oldEncu = $this->getBuilder()->select(['entr_pmas', 'entr_pmenos'])->where('entr_id', $vdata->entr_id)->get()->getRow();
          $data['entr_pmas'] = -1 + (int)($oldEncu->entr_pmas);
          $data['entr_pmenos'] = 1 + (int)($oldEncu->entr_pmenos);
          $this->getBuilder()->where('entr_id', $vdata->entr_id)->update($data);
        }
        else return -1;
      }
      else if ($dataUsuaEntr->rela_nmas == 0 && $dataUsuaEntr->rela_nmenos == 1) {
        if ($vdata->punto == 'mas') {
          $this->getBuilderUsuaEntr($vdata->entr_id, $vdata->usua_id)->update(['rela_nmas' => 1, 'rela_nmenos' => 0]);

          $oldEncu = $this->getBuilder()->select(['entr_pmas', 'entr_pmenos'])->where('entr_id', $vdata->entr_id)->get()->getRow();
          $data['entr_pmas'] = 1 + (int)($oldEncu->entr_pmas);
          $data['entr_pmenos'] = -1 + (int)($oldEncu->entr_pmenos);
          $this->getBuilder()->where('entr_id', $vdata->entr_id)->update($data);
        }
        else return -1;
      }
    }

  }

  public function getBuilderUsuaEntr($entrId, $usuaId)
  {
    return  $this->builUsuEntr->where([ 'rela_entr_id' => $entrId, 'rela_usua_id' => $usuaId ]);
  }

  public function getPoints($entrId, $usuaId)
  {
    $builderEntrada = $this->db->table($this->table);
    $builderUsuaEntr = $this->getBuilderUsuaEntr($entrId, $usuaId);

    $builderEntrada->select('entr_pmas, entr_pmenos')->where('entr_id', $entrId);
    $resultEntrada = $builderEntrada->get()->getRowArray();
    $builderUsuaEntr->select(['rela_nmas', 'rela_nmenos']);
    $resultUsuaEntr = $builderUsuaEntr->get()->getRowArray();

    return array(
      'pmas_entr' => $resultEntrada['entr_pmas'] ?? null,
      'pmenos_entr' => $resultEntrada['entr_pmenos'] ?? null,
      'nmas_rela' => $resultUsuaEntr['rela_nmas'] ?? null,
      'nmenos_rela' => $resultUsuaEntr['rela_nmenos'] ?? null,
    );
  }

  public function getLastPoints2()
  {
    $builderUsuaEntr = $this->getBuilderUsuaEntr(3, 7);
    $lastDataUsuaEntr = $builderUsuaEntr->select(['rela_nmas', 'rela_nmenos'])->get()->getRowArray();
    return $lastDataUsuaEntr;
  }
}
