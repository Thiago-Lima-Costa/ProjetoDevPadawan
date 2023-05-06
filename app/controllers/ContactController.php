<?php

namespace app\controllers;


class ContactController extends Controller
{

    public array $view = [
		'header' => 'BaseHeader',
		'content' => 'ContactView',
		'footer' => 'BaseFooter'
	];  
	public \app\support\User $user;

	//EXIBE A PAGINA DE CONTATO
    public function index()
    {

		if(isset($_SESSION['session_id']) && isset($_SESSION['user_id'])) {
			validateSessionId();
			$this->user = new \app\support\User($_SESSION['user_id']);
		}

		$this->render();

    }

	//Recebe um formulário de contato
	public function contact()
	{

		// Verifica se o formulário foi enviado e armazena os dados
		if ($_SERVER["REQUEST_METHOD"] == "POST") {

			if (isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['inscrito']) && isset($_POST['mensagem'])) {
			$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
			$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
			$inscrito = filter_input(INPUT_POST, 'inscrito', FILTER_SANITIZE_STRING);
			$mensagem = filter_input(INPUT_POST, 'mensagem', FILTER_SANITIZE_STRING);
			}

			$insert = ['nome_contato'=>$nome, 'email_contato'=>$email, 'texto_contato'=>$mensagem, 'inscrito'=>$inscrito];

			$model = new \app\models\AdmContato();
			$model->insert($insert);
				
		}
		//Retorna para a pagina anterior
		goBack();
	}

}

?>