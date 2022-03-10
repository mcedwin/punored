<?php

namespace App\Models;

use CodeIgniter\Model;

class EncuestasModel extends Model
{
    protected $table = 'encuesta';
    protected $tabDetail = 'encuesta_detalle';
    protected $builder;
    protected $builDetail;
    public function __construct()
    {
        parent::__construct();
        $this->builder = $this->db->table($this->table);
        $this->builDetail = $this->db->table($this->tabDetail);
    }
    
    public function getEncuesta($id) {
        //return ['encuesta'=>, 'detalle'=>]
        return $this->builder
            ->select()
            ->where('encu_id', $id)
            ->where('encu_actual', true)
        ->get()->getRow();
    }

    public function getEncuDetalle($id)
    {
        return $this->builDetail
            ->select()
            ->where('deta_encu_id', $id)
        ->get()->getResult();
    }
}