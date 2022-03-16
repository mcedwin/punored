<?php

namespace App\Controllers;

use CodeIgniter\Model;

class Buscar extends BaseController
{
    public function __construct()
    {
    }
    
    public function index($page = 1)
    {
        $data = ['from' => 'buscar/index'];
        
        $q = $this->request->getGet('q') ?? null;
        if (is_null($q) || empty($q)) $this->dieMsg(false, 'buscador vacio');

        $data['filtros'] = $filters = [
            'entrada' => $this->request->getGet('entrada') ?? null,
        ];

        helper('pagination');
        $quant_results = $this->countListado($q, $filters);
        $quant_to_show = 5;
        $dataPag = setPaginationData($data, $quant_results, $quant_to_show, $page);
        
        $data['Entradas']= $this->getSimilarDataListado($q, $filters, $quant_to_show, $dataPag['start_from_page']);

        $data['q'] = $q;

        $this->showHeader();
        $this->showContent('index', $data);
        $this->showFooter();
    }

    protected function getFields()
    {
        $usuaFlds = array(
            'usua_id', 'usua_nombres', 'usua_apellidos', 'usua_email', 'usua_nick'
        );
        $fldsEntr = array(
            'entr_id', 'entr_tipo_id', 'entr_titulo', 'entr_resumen', 'entr_contenido', 'entr_fechapub',
            'tipo_nombre',
            'cate_nombre',
            ...$usuaFlds
        );
        return $fldsEntr;
    }
    
    protected function getSimilarDataListado(?string $q, $filters = [], ?int $pag_size = null, ?int $offset = null)
    {
        helper('formulario');
        $fields = $this->getFields();

        $builder = $this->db->table('entrada');
        $builder->select($fields)
        ->join('entrada_tipo', 'entr_tipo_id = tipo_id')
        ->join('entrada_categoria', 'entr_cate_id = cate_id')
        ->join('usuario', 'entr_usua_id = usua_id');
        
        $this->GetQS_Build($q, $fields, $builder);
        
        $this->builderFiltered($builder, $filters);

        $builder->orderBy('entr_fechapub', 'DESC');

        if(isset($pag_size) && isset($offset))
            $builder->limit($pag_size, $offset);

        // echo $builder->getCompiledSelect();
        return $builder->get()->getResult();
    }

    protected function GetQS_Build($q, $fields, &$builder)
    {
        $q = preg_replace("/[ \t]+/i", " ", trim($q));
        $qs = explode(" ", $q);
        foreach ($qs as $qidx) {
            $builder->groupStart();
            foreach ($fields as $fld) {
                $builder->orLike($fld, $qidx, 'both');
            }
            $builder->groupEnd();
        }
    }

    protected function countListado($q, $filters = []) {
        $builder = $this->db->table('entrada');
        $this->builderFiltered($builder, $filters);
        $this->GetQS_Build($q, $this->getFields(), $builder);
        $builder->join('entrada_tipo', 'entr_tipo_id = tipo_id')
        ->join('entrada_categoria', 'entr_cate_id = cate_id')
        ->join('usuario', 'entr_usua_id = usua_id');
        return $builder->countAllResults();
    }

    protected function builderFiltered(&$builder, ?array $filters = []) {
        $builder->where('entr_espublico', true);
        if (isset($filters['entrada'])) {
            $builder->where('entr_tipo_id', $filters['entrada']);
            if ($filters['entrada'] == 2) $builder->where('entr_fechaven >', date('Y-m-d H:i:s'));
        }
    }
}