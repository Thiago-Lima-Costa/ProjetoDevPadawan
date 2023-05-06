<?php

//Recebe o ID do usuário e o email e retorna um ID de sessão personalizado
function generateSessionId(string $user_id, string $email):string
{
    $user_agent =  $_SERVER['HTTP_USER_AGENT'];
    $time = time();

    $data = "{$user_id}&&&{$email}&&&{$user_agent}&&&{$time}";

    $sessionId = encrypt($data);

    return $sessionId;
}

?>