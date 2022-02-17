<?php

namespace App\Controllers;
use App\Models\EntradaModel;

class Anuncios extends BaseController
{
    public function index($rowno = 0)
	{
		$this->showHeader();
		$this->ShowContent('index');
		$this->showFooter();
	}
}
