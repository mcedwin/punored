<?php

namespace App\Controllers;

class Portada extends BaseController
{
    public function index()
	{
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
