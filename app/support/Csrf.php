<?php

namespace app\support;

class Csrf
{
    //Incluir as funções para prevenção de csrf em todos os formulários que já foram criados anteriormente
    public static function getToken()
    {
        if(isset($_SESSION['_token'])) {
            unset($_SESSION['_token']);
        }

        $user_agent =  $_SERVER['HTTP_USER_AGENT'];
        $addr =  $_SERVER['REMOTE_ADDR'];

        $_SESSION['_token'] = md5(uniqid()).'-'.md5($user_agent).'-'.md5($addr);

        return "<input type='hidden' name='_token' value='{$_SESSION['_token']}'>";
    }

    public static function validateToken()
    {
        if(!isset($_SESSION['_token'])) {
            $err = new \app\controllers\ErrorController();
            die();
        } else if(!isset($_POST['_token'])) {
            $err = new \app\controllers\ErrorController();
            die();
        } else if($_SESSION['_token'] != $_POST['_token']) {
            $err = new \app\controllers\ErrorController();
            die();
        }

        $user_agent =  md5($_SERVER['HTTP_USER_AGENT']);
        $addr =  md5($_SERVER['REMOTE_ADDR']);
        $data = explode('-', $_SESSION['_token']);

        if($user_agent != $data[1]) {
            $err = new \app\controllers\ErrorController();
            die();
        } else if($addr != $data[2]) {
            $err = new \app\controllers\ErrorController();
            die();
        }

        unset($_SESSION['_token']);
        return true;
    }
}

?>