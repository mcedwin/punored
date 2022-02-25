<?php 

namespace App\Models;

use CodeIgniter\Model;

class AnunciosModel extends Model
{
    protected $table = 'entrada';
    var $fields;
    protected $entr_tipo = 2;
    public function __construct()
    {
        parent::__construct();
        $this->fields = array(
        'entr_tipo_id' => array('label' => 'Tipo de entrada', 'type' => 'hidden', 'required' => false),
        'entr_titulo' => array('label' => 'Titulo'),
        'entr_contenido' => array('label' => 'Descripción'),
        'entr_url' => array('label' => 'Pagina web de referencia', 'required' => false),
        'entr_foto' => array('label' => 'Imagen','required' => false),
        'entr_fechaven' => array('label' => 'Fecha Vencimiento'),
        'entr_cate_id' => array('label' => 'Categoria'),
        );

        $dfields = $this->db->getFieldData('entrada');

        foreach ($dfields as $reg) {
        if (!isset($this->fields[$reg->name])) continue;
        $this->fields[$reg->name]['type'] = isset($this->fields[$reg->name]['type']) ? $this->fields[$reg->name]['type'] : $reg->type;
        $this->fields[$reg->name]['name'] = isset($this->fields[$reg->name]['name']) ? $this->fields[$reg->name]['name'] : $reg->name;
        $this->fields[$reg->name]['max_length'] = $reg->max_length;
        $this->fields[$reg->name]['value'] =  isset($this->fields[$reg->name]['value']) ? $this->fields[$reg->name]['value'] : '';
        $this->fields[$reg->name]['required'] =  isset($this->fields[$reg->name]['required']) ? $this->fields[$reg->name]['required'] : true;
        $this->fields[$reg->name] = (object) $this->fields[$reg->name];
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