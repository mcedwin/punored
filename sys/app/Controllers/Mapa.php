<?php

namespace App\Controllers;
use App\Models\EntradaModel;

class Mapa extends BaseController
{
    public function index($rowno = 0)
	{
		$this->addCss(array(
			'lib/leaflet/leaflet.css'
		));
		$this->addJs(array(
			'lib/leaflet/leaflet.js',
			'js/mapa/mostrar.js'
		));
		$this->showHeader();
		$this->ShowContent('index');
		$this->showFooter();
	}

	public function crear(){
		$this->addCss(array(
			'lib/leaflet/leaflet.css'
		));
		$this->addJs(array(
			'lib/leaflet/leaflet.js',
			'js/mapa/mostrar.js'
		));
		$this->showHeader();
		$this->ShowContent('form');
		$this->showFooter();
	}
}
