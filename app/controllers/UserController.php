<?php

namespace app\controllers;


class UserController extends Controller
{

    public array $view = [
		'header' => 'BaseHeader',
		'content' => 'ProfileView',
		'footer' => 'BaseFooter'
	];
	public \app\support\User $user;


	public function __construct()
	{
		
		if(isset($_SESSION['session_id']) && isset($_SESSION['user_id'])) {
			validateSessionId($_SESSION['session_id']);

			$this->user = new \app\support\User($_SESSION['user_id']);
		}

	}


    function profile()
    {
		$this->view = [
			'header' => 'BaseHeader',
			'content' => 'ProfileView',
			'footer' => 'BaseFooter'
		];

		$this->render();
    }


	function editView()
    {
		$this->view = [
			'header' => 'AltHeader',
			'content' => 'EditProfileView',
			'footer' => 'BaseFooter'
		];

		$this->render();
    }


	//Executa as altereções no perfil realizadas pelo proprio usuario
	function editImage()
    {

		validateSessionId();
		// Verifica se foi enviado algum arquivo
		if (!isset($_FILES['userImage']) || $_FILES['userImage']['error'] == '4' || $_FILES['userImage']['tmp_name'] == '') {
			//Cria erro para insira um arquivo
			$_SESSION['change_image_failure'] = 1;
			header('HTTP/1.1 307 Temporary Redirect');
			header('Location: /editview');
			die();
		}

		//Verifica se houve algum erro no upload
		if ($_FILES['userImage']['error'] != UPLOAD_ERR_OK && $_FILES['userImage']['error'] != 0) {
			$_SESSION['change_image_failure'] = 1;
			header('HTTP/1.1 307 Temporary Redirect');
			header('Location: /editview');
			die();
		}

		// Verifica se é uma imagem
		//MIME = Multipurpose Internet Mail Extensions
		$mime = mime_content_type($_FILES['userImage']['tmp_name']);
		if (strpos($mime, 'image') !== 0) {
			$_SESSION['change_image_failure'] = 1;
			header('HTTP/1.1 307 Temporary Redirect');
			header('Location: /editview');
			die();
		}

		//Verifica a extensao e limita o tipo da imagem à jpeg, jpg e png
		$extension = pathinfo($_FILES['userImage']['name'], PATHINFO_EXTENSION); 
		if ($extension != 'jpeg' && $extension != 'jpg' && $extension != 'png') {
			$_SESSION['change_image_failure'] = 1;
			header('HTTP/1.1 307 Temporary Redirect');
			header('Location: /editview');
			die();
		}

		// Define o novo nome do arquivo e a pasta de destino
		$newName =   'userImage_'.$this->user->user_id.'.'.$extension;
		$destination = __DIR__.'/../../public/Assets/img/user_profile/'.$newName;
		
		//Verifica se o user ja possui uma imagem e apaga ela antes de salvar a nova imagem
		$oldImage = __DIR__.'/../../public/Assets/img/user_profile/'.'userImage_'.$this->user->user_id.'.*';
		$arquivos = glob($oldImage); // glob() busca os arquivos que correspondem ao padrao
		foreach ($arquivos as $arquivo) { // itera sobre os arquivos encontrados
			if (file_exists($arquivo)) { // verifica se o arquivo existe
				unlink($arquivo); // deleta o arquivo
			}
		}

		//Salva a nova imagem do usuario, e chama a funcao resizeImage 
		move_uploaded_file($_FILES['userImage']['tmp_name'], $destination);
		resizeImage($destination, 100, 100);

		//Salva o nome da imagem de usuario no BD
		$imagePathForDB = 'Assets/img/user_profile/'.$newName;
		$userPerfil = new \app\models\UserPerfil();
      	$userPerfil->updateProfile('foto', $imagePathForDB, $this->user->user_id);

		header('HTTP/1.1 307 Temporary Redirect');
		header('Location: /editview');
	}



	//Executa as altereções no perfil realizadas pelo proprio usuario
	function editProfile()
    {
		//$_POST["nascimento"] >>> Guarda o valor inserido no formulario pelo usuario (nesse caso no formulario data de nascimento)
		//$_POST["campo"] >>> Guarda o nome da variavel POST que contem o valor (nesse caso guardará a string 'nascimento')

		if ($_SERVER["REQUEST_METHOD"] == "POST") {

			if (isset($_POST["campo"])) {

				$field = $_POST["campo"];

				if (isset($_POST[$field])) { 

					if ($field == 'interesses') {
						$valores_array = $_POST[$field];
						$valores_string = implode(',', $valores_array);
						$value = filter_var($valores_string);
					} else {
						$value = filter_input(INPUT_POST, $field, FILTER_SANITIZE_STRING);
					}				

					validateSessionId();
					$user_id = $this->user->user_id;

					$userPerfil = new \app\models\UserPerfil();
      				$userPerfil->updateProfile($field, $value, $user_id);
				}

			}

			header('HTTP/1.1 307 Temporary Redirect');
			header('Location: /editview');
		}	
    }


	//Executa a alterecao de senha realizada pelo proprio usuario
	function editPassword()
    {
		validateSessionId();
		
		if ($_SERVER["REQUEST_METHOD"] == "POST") { 

			//Caso algum dos campos não esteja preenchido cria uma variavel SESSION para acionar o alert no frontend
			if ($_POST["senha_atual"] == '' || $_POST["senha_nova1"] == '' || $_POST["senha_nova2"] == '') {
				$_SESSION['change_password_failure'] = 1;
				header('HTTP/1.1 307 Temporary Redirect');
				header('Location: /editview');
				die();
			}

			//Sanitiza os valores recebidos
			$senha_atual = filter_input(INPUT_POST, 'senha_atual', FILTER_SANITIZE_STRING);
			$senha_nova1 = filter_input(INPUT_POST, 'senha_nova1', FILTER_SANITIZE_STRING);
			$senha_nova2 = filter_input(INPUT_POST, 'senha_nova2', FILTER_SANITIZE_STRING);

			//Caso as duas senha informadas não sejam iguais cria uma variavel SESSION para acionar o alert no frontend
			if ($senha_nova1 != $senha_nova2) {
				$_SESSION['change_password_failure'] = 2;
				header('HTTP/1.1 307 Temporary Redirect');
				header('Location: /editview');
				die();
			}

			//Caso a nova senha nao seja valida cria uma variavel SESSION para acionar o alert no frontend
			if (!validateInput('password', $senha_nova1)) {
				$_SESSION['change_password_failure'] = 3;
				header('HTTP/1.1 307 Temporary Redirect');
				header('Location: /editview');
				die();
			}

			//Recupera os dados do usuario no BD
			$userCadastro = new \app\models\UserCadastro();
      		$user = $userCadastro->findBy('id_user', $this->user->user_id);

			//Verifica se a senha atual informada esta correta, caso positivo altera a senha
			if (password_verify($senha_atual, $user[0]['senha'])) {
				$hash = password_hash($senha_nova1, PASSWORD_DEFAULT);
				$userCadastro->update('senha', $hash, 'id_user', $this->user->user_id);
			} else {
				$_SESSION['change_password_failure'] = 4;
				header('HTTP/1.1 307 Temporary Redirect');
				header('Location: /editview');
				die();
			}


		}

			header('HTTP/1.1 307 Temporary Redirect');
			header('Location: /editview');
	}
		
}

?>