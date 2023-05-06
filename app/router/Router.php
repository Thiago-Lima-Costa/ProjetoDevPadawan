<?php

namespace app\router;

class Router
{

	//RETORNA O ARRAY DE ROTAS
    public static function routes():array
    {
		return [

			'GET' => [
				'/' => ['HomeController', 'index'],
				'/rules' => ['HomeController', 'rules'],
				'/privacy' => ['HomeController', 'privacy'],
				'/statistics' => ['HomeController', 'statistics'],
				'/team' => ['HomeController', 'team'],
				'/register' => ['RegisterController', 'index'],
				'/logout' => ['LoginController', 'logout'],
				'/profile' => ['UserController', 'profile'],
				'/forum' => ['ForumController', 'index'],
				'/forum/([a-zA-Z0-9_-]+)' => ['ForumController', 'forum'],
				'/forum/([a-zA-Z0-9_-]+)/([a-zA-Z0-9_-]+)' => ['ForumController', 'showTopic'],
				'/blog' => ['BlogController', 'index'],
				'/blog/([a-zA-Z0-9_-]+)' => ['BlogController', 'article'],
				'/tests' => ['TestController', 'index'],
				'/recover' => ['RecoveryController', 'index'],
				'/recover/([a-zA-Z0-9_-]+)' => ['RecoveryController', 'recoverForm'],
				'/panel' => ['PanelController', 'index'],
				'/panel/([a-zA-Z0-9_-]+)' => ['PanelController', 'index'],
				'/error' => ['ErrorController', 'message'],
				'/contact' => ['ContactController', 'index'],
			],


			'POST' => [
				'/register/register' => ['RegisterController', 'register'],
				'/login' => ['LoginController', 'login'],
				'/editview' => ['UserController', 'editView'],
				'/editprofile' => ['UserController', 'editProfile'],
				'/editpassword' => ['UserController', 'editPassword'],
				'/editimage' => ['UserController', 'editImage'],
				'/forum/replypost' => ['ForumController', 'replyPost'],
				'/forum/newtopic' => ['ForumController', 'newTopic'],
				'/forum/report' => ['ForumController', 'report'],
				'/recoverpass' => ['RecoveryController', 'recoverPass'],
				'/passwordreset' => ['RecoveryController', 'passwordReset'],
				'/panel/enviar-artigo' => ['PanelController', 'enviarArtigo'],
				'/panel/editArticle' => ['PanelController', 'editArticle'],
				'/panel/enviar-aviso' => ['PanelController', 'enviarAviso'],
				'/panel/enviar-mensagem' => ['PanelController', 'enviarMensagem'],
				'/penalidade/advertencia' => ['PenaltyController', 'advertir'],
				'/penalidade/suspensao' => ['PenaltyController', 'suspender'],
				'/penalidade/banimento' => ['PenaltyController', 'banir'],
				'/penalidade/remover' => ['PenaltyController', 'removerPenalidade'],
				'/penalidade/alterarNivelDeAcesso' => ['PenaltyController', 'alterarNivelDeAcesso'],
				'/contact/contact' => ['ContactController', 'contact'],
			],
			
		];
        
	}
}

?>