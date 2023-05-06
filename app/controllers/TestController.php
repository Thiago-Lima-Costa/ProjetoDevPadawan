<?php

namespace app\controllers;


class TestController extends Controller
{   
    public array $view = [
		'header' => 'BaseHeader',
		'content' => 'TestView',
		'footer' => 'BaseFooter'
	];


    function index()
    {
		$this->render();
    }
}




?>