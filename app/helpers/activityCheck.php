<?php

//Verifica se já existe uma sessao iniciada, caso não haja, inicia uma
function activityCheck() {   

    // Verifica se a ultima atividade foi mais de 30 minutos atras
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1800)) {
        
        //Caso o usuario esteja inativo a mais de 30 minutos encerra a sessao, e cria um alerta informando que a sessao expirou
        session_unset();
        session_destroy();

        checkSession();

        //Cria uma variavel SESSION que irá exibir um Modal no frontend
        $_SESSION['login_failure'] = [
            'title' => 'SESSÃO EXPIRADA!',
            'message' => 'Esta sessão expirou, por favor realize o login novamente!',
            'session_name' => 'login_failure',
            'unset_variable' => true
        ];

        header('Location: /');
        die();

    } else if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] <= 1800)) {

        //Atualiza a hora da ultima atividade do usuario renovando o tempo da sessao
        $_SESSION['last_activity'] = time();

    }

}


?>