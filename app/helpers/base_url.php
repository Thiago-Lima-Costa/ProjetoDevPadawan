<?php

function base_url($path = '') {
    //Verifica se a URL começa com http ou https
    $protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') === false ? 'http' : 'https';
    //Recupera o nome do host
    $host = $_SERVER['HTTP_HOST'];
    //Recupera o base path
    $base_path = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
    //Remove barras extras no final do base path
    $base_path = rtrim($base_path, '/');

    //Forma a URL base
    $base_url = $protocol . '://' . $host . $base_path;

    //Adiciona, caso seja passado como argumento, o caminho adicional a URL base
    if (!empty($path)) {
        $base_url .= '/' . ltrim($path, '/');
    }

    return $base_url;
}

?>