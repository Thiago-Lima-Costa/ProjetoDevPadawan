<?php

namespace app\controllers;

abstract class Controller
{

    //Define o layout do controller
	public array $view = [
		'header' => 'BaseHeader',
		'content' => '',
		'footer' => 'BaseFooter'
	];

    //Renderiza o layout da pagina
	public function render()
    {
		ob_start();
		include("../app/views/partials/".$this->view['header'].".php");
		include("../app/views/contents/".$this->view['content'].".php");
		include("../app/views/partials/".$this->view['footer'].".php");
		ob_end_flush();
	}

	public function __get($attribute)
    {
        return $this->$attribute;
    }


    public function __set($attribute, $value)
    {
        $this->$attribute = $value;
    }
}

?>