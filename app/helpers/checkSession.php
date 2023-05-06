<?php

//Verifica se já existe uma sessao iniciada, caso não haja, inicia uma
function checkSession() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
}


?>