<?php

//Desfaz uma criptografia criada pela funcao encrypt()
function decrypt($data) {
  
    // A chave de criptografia funciona como uma senha, deve ser mantida ou guardada para o processo de decriptografia
    $key = 'chave-de-criptografia';

    // Algoritmo de criptografia 
    $method = "aes-256-cbc";

    // Decodificar a base64
    $encrypted_data = base64_decode($data);

    // Separar o IV do dado criptografado
    $iv_size = openssl_cipher_iv_length($method);
    $iv = substr($encrypted_data, 0, $iv_size);
    $encrypted_data = substr($encrypted_data, $iv_size);

    // Descriptografar a string usando OpenSSL
    $decrypted_data = openssl_decrypt($encrypted_data, $method, $key, OPENSSL_RAW_DATA, $iv);


    return $decrypted_data;

}


?>