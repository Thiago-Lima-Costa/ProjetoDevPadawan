<?php

//Recebe uma string como argumento e retorna uma string criptografada
function encrypt(string $data):string {
    
    // A chave de criptografia funciona como uma senha, deve ser mantida ou guardada para o processo de decriptografia
    $key = 'chave-de-criptografia';

    // Algoritmo de criptografia 
    $method = "aes-256-cbc";

    // Gerar um vetor de inicialização aleatorio
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));

    // Criptografar a string recebida por parametro usando OpenSSL
    $encrypted_data = openssl_encrypt($data, $method, $key, OPENSSL_RAW_DATA, $iv);

    // Encode na base64 para facilitar a transmissão e armazenamento
    $encrypted_data = base64_encode($iv . $encrypted_data);

    return $encrypted_data;

}


?>