<?php

function uri_format($string)
{
    //Remove espaços, letras maiusculas, acentos e caracteres especiais da string para que ela possa ser usada em uma URI
    $uri = trim($string);
    $uri = str_replace(' ', '-', $uri);
    $uri = strtolower($uri);
    $uri = iconv('UTF-8', 'ASCII//TRANSLIT', $uri);
    $uri = preg_replace("/[^a-zA-Z0-9_\-\s]/", "", $uri);
   
    return $uri;
}

?>