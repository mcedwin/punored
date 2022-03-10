<?php

namespace App\Models;

use CodeIgniter\Model;

class MapaModel extends Model
{
    protected $table = 'entrada';
    var $db;
    var $fields;
    protected $entr_tipo = 4;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
        $this->fields = array(
            'entr_tipo_id' => array('label' => 'Tipo de entrada', 'type' => 'hidden', 'required' => false),
            'entr_titulo' => array('label' => 'Titulo'),
            'entr_contenido' => array('label' => 'Contenido'),
            'entr_foto' => array('label' => 'Imagen'),
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
    public function getFields($type = 'all')
    {
        return $this->fields;
    }
    public function get($id = '')
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
    public function getMapaData($filters = [], $pag_size = 5, $offset = 0)
    {
        $builder = $this->getBuilder();
        $query = $builder->select([
            'entr_id',
            'entr_titulo',
            'entr_contenido',
            'entr_foto',
            'entr_fechapub',
            'entr_map_lat',
            'entr_map_lng',
        ])->select('usua_nombres')->select('cate_nombre');
        
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
}
