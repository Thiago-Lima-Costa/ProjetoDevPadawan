<?php

namespace app\controllers;


class ErrorController extends Controller
{   
    public static string $errorMessage = "Ops, algo deu errado! Não foi possível conectar ao nosso sistema no momento. Pedimos desculpas pelo transtorno e estamos trabalhando para solucionar o problema o mais rápido possível. Por favor, tente novamente mais tarde.";
    protected static string $message;
	protected string $user;

    public function __get($attribute)
    {
        return $this->$attribute;
    }


    public function __set($attribute, $value)
    {
        $this->$attribute = $value;
    }

    public function __construct($msg = '', $userId = '')
    {
        if($msg != '') {
            $this->__set('message', $msg);
        }
        if($userId != '') {
            $this->__set('user', $userId);
        }
       // self::handleErrors();
        include_once("../app/views/contents/errorView.php");
    }
    
   /* public static function handleErrors()
    {
        set_error_handler(function($errno, $errstr, $errfile, $errline) {
            throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
        });

        set_exception_handler(function($exception) {

            if(self::$message != '') {
                $msg = $this->__get('message');
            } else {
                $msg = '';
            }

            if($this->user != '') {
                $id_user = $this->__get('user');
            }
            
            $mensagem = $msg.$exception->getMessage();

            $insert = ['id_user'=>$id_user, 'mensagem_erro'=>$mensagem];

			$model = new \app\models\LogErros();
			$model->insert($insert);
    
            include_once("../app/views/contents/errorView.php");
            die();
        });
    } */

}

?>