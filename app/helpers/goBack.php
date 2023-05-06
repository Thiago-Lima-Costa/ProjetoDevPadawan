<?php

//Retorna para a pagina anterior
function goBack() {
    
    // Verifica se o cabecalho HTTP_REFERER existe
  if (isset($_SERVER['HTTP_REFERER'])) {
    // Redireciona para a página anterior
    header('Location: ' . $_SERVER['HTTP_REFERER']);
  } else {
    // Se o cabeçalho HTTP_REFERER nao existir, redireciona para a pagina inicial
    header('Location: /');
  }
  exit();
    
}


?>