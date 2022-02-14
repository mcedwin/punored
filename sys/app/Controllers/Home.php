<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
	{
		$this->showHeader();
		$this->showContent('welcome');
		$this->showFooter();
	}

	public function miembros(){
		$this->showHeader();
		$this->showContent('miembros');
		$this->showFooter();
	}
	public function encuestas(){
		$this->showHeader();
		$this->showContent('encuestas');
		$this->showFooter();
	}
	public function incidencias(){
		$this->showHeader();
		$this->showContent('incidencias');
		$this->showFooter();
	}
}
