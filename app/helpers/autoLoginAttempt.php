<?php

//Verifica se o usuario fez um login anterior com a opcao de "lembrar-me"
function autoLoginAttempt() {
    
  try {
    //Verifica se foi definido o cookie para lembrar a sessao do usuario
    if (isset($_COOKIE['DPRemember'])) {
       
      //Recupera o cookie e decriptografa as informacoes
      $cookie = filter_var($_COOKIE['DPRemember'], FILTER_SANITIZE_STRING);
      $userData = decrypt($cookie);
      
      //Converte as informacoes de JSON para objeto
      $userData = json_decode($userData);
        
      //PROCEDIMENTOS PARA EFETUAR O LOGIN
      $userId = filter_var($userData->user_id, FILTER_SANITIZE_STRING);
      $sessionId = filter_var($userData->session_id, FILTER_SANITIZE_STRING);

      $user = new \app\models\UserCadastro();
      $userExist = $user->findBy('id_user', $userId);

      //Confere se o ID do usuario e o email constam no cadastro de usuarios
      if(isset($userExist[0]['id_user'])) {

        checkSession();

        $_SESSION['user_id'] = $userId;
        $_SESSION['session_id'] = $sessionId;

        validateSessionId();

      } else {
        setcookie('DPRemember', '', time() - 3600, "/");
        session_unset();
        session_destroy();
        header('Location: /');
        die();
      }
        
    }

  } catch (Exception $e) {

    if (isset($_COOKIE['DPRemember'])) {
      setcookie('DPRemember', '', time() - 3600, "/");
    }

    session_unset();
    session_destroy();
    header('Location: /');
    die();
  }
      

}


?>