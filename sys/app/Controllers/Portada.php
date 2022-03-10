<?php

namespace App\Controllers;

use App\Models\EntradaModel;

class Portada extends BaseController
{
    var $notiModel;
    public function __construct()
    {
        $this->notiModel = new EntradaModel(1);
    }
    public function index()
	{
        $this->datos['noticias'] = $this->notiModel->getBuilder()->limit(3)->orderBy('entr_pmas' , 'DESC')->get()->getResult();
		$this->showHeader();
		$this->showContent('index');
		$this->showFooter();
	}

	public function acerca(){
		$this->showHeader();
		$this->showContent('acerca');
		$this->showFooter();
	}

	public function crear(){
		$this->showHeader();
		$this->showContent('crear');
		$this->showFooter();
	}
}
