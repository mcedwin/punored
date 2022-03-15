<?php

namespace App\Controllers;

class Buscar extends BaseController
{
    public function __construct()
    {
        
    }
    
    public function index()
    {
        helper('formulario');
        $q = $this->request->getGet('q') ?? null;
        
    }

    function getSimilarData($q)
    {
        helper('formulario');

    }
}