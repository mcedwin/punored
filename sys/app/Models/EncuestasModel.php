<?php

namespace App\Models;

use CodeIgniter\Model;

class EncuestasModel extends Model
{
    protected $table = 'encuesta';
    protected $tabDetail = 'encuesta_detalle';
    protected $builder;
    protected $builDetail;
    var $fields = [];

    public function __construct()
    {
        parent::__construct();
        $this->builder = $this->db->table($this->table);
        $this->builDetail = $this->db->table($this->tabDetail);

        $this->fields = array(
            'encu_titulo' => array('label' => 'Titulo'),
            'encu_descripcion' => array('label' => 'Descripcion'),
            'encu_foto' => array('label' => 'Imagen', 'required' => false),
            // 'encu_actual' => array('label' => 'Imagen', 'required' => false),
        );

        helper('funciones');
        $dfields = $this->db->getFieldData('encuesta');
        iniFields($dfields, $this->fields);
    }
    function get($id = '')
    {
        $builder = $this->db->table($this->table);

        if (!empty($id)) {
            $row = $builder->select()->where('encu_id', $id)->get()->getRow();
            foreach ($row as $k => $value) {
                if (!isset($this->fields[$k])) continue;
                $this->fields[$k]->value =  $value;
            }
        }
        return (object)$this->fields;
    }
    
    public function getFullEncuesta($id) {
        return [
            'encuesta' => $this->getEncuesta($id),
            'detalle' => $this->getEncuDetalle($id),
        ];
    }

    public function getEncuesta($id) {
        return $this->builder->select()->where('encu_id', $id)->where('encu_actual', true)->get()->getRow();
    }

    public function getEncuDetalle($id)
    {
        return $this->builDetail->select()->where('deta_encu_id', $id)->get()->getResult();
    }

    public function getEncuBuildWhere($fields = '*',?array $where = []) {
        $this->builder->select($fields);
        if ($where != null)
            foreach ($where as $key => $value)
                $this->builder->where($key, $value);
        return $this->builder;
    }

    public function getListado($filters = [], $pag_size = null, $offset = null)
    {
        $this->builder->select();
        if (isset($filters['usuario']))
            $this->builder->where('encu_usua_id', $filters['usuario']);
        if (isset($pag_size) && isset($offset))
            $this->builder->limit($pag_size, $offset);
        return $this->builder->get()->getResult();
    }
    
    public function countListado($filters = [])
    {
        if (isset($filters['usuario']))
            $this->builder->where('encu_usua_id',$filters['usuario']);
        return $this->builder->countAllResults();
    }
}