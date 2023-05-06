<?php

function validateSessionId()
{
    try {

        $data = decrypt($_SESSION['session_id']);
        $data = explode('&&&', $data);

        list($user_id, $email, $user_agent, $time) = $data;
        
        if($user_id != $_SESSION['user_id'] || $user_agent != $_SERVER['HTTP_USER_AGENT']) {
            if (isset($_COOKIE['DPRemember'])) {
                setcookie('DPRemember', '', time() - 3600, "/");
              }
            session_unset();
            session_destroy();
            header('Location: /');
        } else if ((time() - $time > 604800)) {
            if (isset($_COOKIE['DPRemember'])) {
                setcookie('DPRemember', '', time() - 3600, "/");
              }
            session_unset();
            session_destroy();
            header('Location: /');
        } else {
            return true;
        }

    } catch (Exception $e) {
        if (isset($_COOKIE['DPRemember'])) {
            setcookie('DPRemember', '', time() - 3600, "/");
          }
        session_unset();
        session_destroy();
        header('Location: /');
    }
    
}

?>