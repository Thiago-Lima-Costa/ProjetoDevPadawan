<?php

namespace app\controllers;
use app\models\Connection;

class RegisterController extends Controller
{

  public array $view = [
	  'header' => 'AltHeader',
		'content' => 'RegisterView',
		'footer' => 'AltFooter'
	];
    

  function index()
  {
    checkSession();

		$this->render();
    
  }


  public function register()
  {

    $cadUser;
    $perfilUser;
    $filled = false;
    $validated = false;

    //Sanitiza os dados recebidos via POST
    // Sanitiza os dados recebidos via POST
    // Sanitiza os dados recebidos via POST
    $userName = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $pass1 = filter_input(INPUT_POST, 'senha1', FILTER_SANITIZE_SPECIAL_CHARS);
    $pass2 = filter_input(INPUT_POST, 'senha2', FILTER_SANITIZE_SPECIAL_CHARS);


    //Verifica se todos os campos estao preenchidos
    if ($userName == '') {

      //Cria uma variavel SESSION que irá exibir um Modal no frontend
      $_SESSION['register_failure'] = [
        'title' => 'CAMPO OBRIGATÓRIO',
        'message' => 'Insira um nome de usuário',
        'session_name' => 'register_failure',
        'unset_variable' => true
      ];
      
      header('Location: /register');	
      die();
    
    } else if ($email == '') {

      //Cria uma variavel SESSION que irá exibir um Modal no frontend
      $_SESSION['register_failure'] = [
        'title' => 'CAMPO OBRIGATÓRIO',
        'message' => 'Insira um e-mail',
        'session_name' => 'register_failure',
        'unset_variable' => true
      ];
      
      header('Location: /register');
      die();

    }else if($pass1 == '') {

      //Cria uma variavel SESSION que irá exibir um Modal no frontend
      $_SESSION['register_failure'] = [
        'title' => 'CAMPO OBRIGATÓRIO',
        'message' => 'Insira uma senha',
        'session_name' => 'register_failure',
        'unset_variable' => true
      ];

      header('Location: /register');
      die();

    } else if ($pass1 != '' && $pass2 == '') {

      //Cria uma variavel SESSION que irá exibir um Modal no frontend
      $_SESSION['register_failure'] = [
        'title' => 'CAMPO OBRIGATÓRIO',
        'message' => 'Insira a senha novamente',
        'session_name' => 'register_failure',
        'unset_variable' => true
      ];

      header('Location: /register');
      die();

    } else if ($pass1 !== $pass2) {

      //Cria uma variavel SESSION que irá exibir um Modal no frontend
      $_SESSION['register_failure'] = [
        'title' => 'ERRO NO PREENCHIMENTO',
        'message' => 'As duas senhas inseridas precisam ser iguais',
        'session_name' => 'register_failure',
        'unset_variable' => true
      ];

      header('Location: /register');
      die();

    } else {

      $filled = true;

    }
  

    //Verifica se os dados inseridos estao dentro do padrao estabelecido
    if (!validateInput('email', $email) || !validateInput('nick', $userName) || !validateInput('password', $pass1)) {

      if (!validateInput('email', $email)) {

        //Cria uma variavel SESSION que irá exibir um Modal no frontend
        $_SESSION['register_failure'] = [
        'title' => 'ERRO NO PREENCHIMENTO',
        'message' => 'Insira um endereço de e-mail válido!',
        'session_name' => 'register_failure',
        'unset_variable' => true
        ];

        header('Location: /register');
        die();

       } else if (!validateInput('nick', $userName)) {

        //Cria uma variavel SESSION que irá exibir um Modal no frontend
          $_SESSION['register_failure'] = [
          'title' => 'ERRO NO PREENCHIMENTO',
          'message' => 'O nome de usuário ter entre 3 e 20 caracteres, deve ser formado apenas por letras, números, traço (-), underscore (_) ou ponto (.)!',
          'session_name' => 'register_failure',
          'unset_variable' => true
          ];
  
          header('Location: /register');
          die();
 
      } else if (!validateInput('password', $pass1)) {

        //Cria uma variavel SESSION que irá exibir um Modal no frontend
        $_SESSION['register_failure'] = [
          'title' => 'ERRO NO PREENCHIMENTO',
          'message' => 'A senha deve possuir entre 8 e 12 caracteres, deve possuir ao menos uma letra maiúscula, uma letra minúscula, um número e um dos seguintes caracteres especiais: !, @, #, $, %, ^, & ou *.',
          'session_name' => 'register_failure',
          'unset_variable' => true
          ];
  
          header('Location: /register');
          die();

      }

    } else {

      $cadUser = new \app\models\UserCadastro();
      $userExist = $cadUser->counter('email', $email);

      $perfilUser = new \app\models\UserPerfil();
      $userNameExist = $perfilUser->counter('nickname', $userName);
      
      if ($userExist[0][0] != 0) {

        //Cria uma variavel SESSION que irá exibir um Modal no frontend
        $_SESSION['register_failure'] = [
          'title' => 'E-MAIL JÁ CADASTRADO',
          'message' => 'O e-mail informado já foi cadastrado, verifique os dados informados!',
          'session_name' => 'register_failure',
          'unset_variable' => true
          ];
  
          header('Location: /register');
          die();

      } else if ($userNameExist[0][0] != 0) {

        //Cria uma variavel SESSION que irá exibir um Modal no frontend
        $_SESSION['register_failure'] = [
          'title' => 'NOME DE USUÁRIO JÁ CADASTRADO',
          'message' => 'O nome de usuário informado já está sendo usado por outro usuário, por favor escolha outro nome!',
          'session_name' => 'register_failure',
          'unset_variable' => true
          ];
  
          header('Location: /register');
          die();

      } else {

        $validated = true;

      }

    }

    //Insere o novo usuario no BD e cria uma nova sessao autenticada
    if ($filled = true && $validated = true) {

      try {
        //Finaliza o cadastro inserindo os dados no BD
        $transaction = new \app\models\Transaction();
        $transaction->finalizeRegister($email, $pass1, $userName);
        
        //Cria uma nova sessão autenticada
        $firstLogin = new \app\controllers\LoginController();
        $firstLogin->firstLogin($email);

        //Direciona para a pagina inicial
        header('Location: /');

      } catch (\PDOException $e) {
        $err = new \app\controllers\ErrorController($e);
      }

    }
		
	}

}