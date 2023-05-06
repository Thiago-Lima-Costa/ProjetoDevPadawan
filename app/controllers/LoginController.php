<?php

namespace app\controllers;

class LoginController extends Controller
{

  //Verifica se o usuario e senha estao corretos e caso estejam realiza o login
  public function login()
  {
    
    checkSession();

    // Verifica se o formulário foi enviado
    if (isset($_POST['email']) && isset($_POST['senha'])) {
      
      // Armazena os dados do formulário em variáveis
      $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
      $password = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);
      
      //Verifica se o usuário esta cadastrado
      $user = new \app\models\UserCadastro();
      $userExist = $user->findBy('email', $email);
      
      if (in_array($email, $userExist[0])) {
        
        //Verifica se a senha esta correta, caso positivo recupera os dados do usuario e autoriza o login
        if (password_verify($password, $userExist[0]['senha'])) {

          $loggedUser = new \app\support\User($userExist[0]['id_user']);
          
          $_SESSION['session_id'] = generateSessionId($userExist[0]['id_user'], $userExist[0]['email']);
          $_SESSION['user_id'] = $loggedUser->__get('user_id');

          //Verifica de o usuario esta banido do portal
          if($loggedUser->banido == 1){

            session_unset();
            session_destroy();
            checkSession();

            $_SESSION['login_failure'] = [
              'title' => 'USUÁRIO BANIDO!',
              'message' => "Esta usuário está banido do portal!",
              'session_name' => 'login_failure',
              'unset_variable' => true
            ];
            
            header('Location: /');
            die();
          }

          // Verifica se o usuario escolheu a opcao "lembrar-me", caso positivo cria um cookie com os dados do usuario
          if (isset($_POST['remember'])) {

            $loginData = [
              'session_id' => $_SESSION['session_id'],
              'user_id' => $_SESSION['user_id'],
            ];

            //Converte o array em uma string
            $loginData = json_encode($loginData);

            //Criptografa os dados de usuário
            $userData = encrypt($loginData);
  
            //Salva um cookie com os dados da conexao para manter o login do usuario por 7 dias, o cookie somente poderá ser lido no lado servidor (opção httpOnly no ultimo argumento), e somente sera transmitido por uma conexao segura (HTTPS, no penultimo argumento)
            setcookie('DPRemember', $userData, time() + (60 * 60 * 24 * 7), "/", "", true, true);

          } else {

            //Caso o usuario não tenha escolhido a opcao "lembrar-me", cria uma variavel $_SESSION que poderá ser verificada pela funcao activityCheck() e caso o usuario esteja inativo a mais de 30 minutos realiza o logout.
            $_SESSION['last_activity'] = time();

          }

          goBack();

        //Caso a senha nao esteja correta
        } else {
          //Verifica quantas vezes o usuario errou a senha
          $_SESSION['tentativas_de_login'] = isset($_SESSION['tentativas_de_login']) ? $_SESSION['tentativas_de_login'] + 1 : 1;

          //Cria uma variavel SESSION que irá exibir um Modal no frontend
          $_SESSION['login_failure'] = [
            'title' => 'SENHA INCORRETA!',
            'message' => "Tentativa Nr {$_SESSION['tentativas_de_login']}",
            'session_name' => 'login_failure',
            'unset_variable' => true
          ];
          
          header('Location: /');
          die();

        }
       
      //Caso o email nao seja encontrado no banco de dados
      } else {

        //Cria uma variavel SESSION que irá exibir um Modal no frontend
        $_SESSION['login_failure'] = [
          'title' => 'USUÁRIO NÃO CADASTRADO',
          'message' => 'Verifique se o e-mail informado está correto!',
          'session_name' => 'login_failure',
          'unset_variable' => true
        ];
        
        header('Location: /');
        die();

      }
    }
   
	}

  //Encerra uma sessao
  public function logout()
  {
    checkSession();

    if (isset($_COOKIE['DPRemember'])) {
      setcookie('DPRemember', '', time() - 3600, "/");
    }

    session_unset();
    session_destroy();
    goBack();
    die();
  }


  //Realiza o login logo após o cadastro
  public function firstLogin($user_email)
  {
    $cadUser = new \app\models\UserCadastro();
    $user = $cadUser->findBy('email', $user_email);
          
    $_SESSION['session_id'] = generateSessionId($user[0]['id_user'], $user[0]['email']);
    $_SESSION['user_id'] = $user[0]['id_user'];
    $_SESSION['last_activity'] = time();

    //Direciona para a pagina inicial
    header('Location: /');
    die();
  }

}


?>