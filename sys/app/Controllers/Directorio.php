<?php

namespace App\Controllers;
use App\Models\EntradaModel;

class Directorio extends BaseController
{
    public function index($rowno = 0)
	{
		$this->showHeader();
		$this->ShowContent('index');
		$this->showFooter();
	}
}