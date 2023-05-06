<?php

function resizeImage($file_path, $max_width, $max_height)
{
    // Obtem as informacoes da imagem
    list($orig_width, $orig_height, $type) = getimagesize($file_path);
    
    // Calcula as novas dimensoes da imagem
    $ratio_orig = $orig_width / $orig_height;
    if ($max_width / $max_height > $ratio_orig) {
      $max_width = $max_height * $ratio_orig;
    } else {
      $max_height = $max_width / $ratio_orig;
    }
    
    // Cria uma nova imagem com as novas dimensões
    $image_p = imagecreatetruecolor($max_width, $max_height);
    
    // Carrega a imagem original
    switch ($type) {
      case IMAGETYPE_JPEG:
        $image = imagecreatefromjpeg($file_path);
        break;
      case IMAGETYPE_PNG:
        $image = imagecreatefrompng($file_path);
        break;
      case IMAGETYPE_GIF:
        $image = imagecreatefromgif($file_path);
        break;
      default:
        return false;
    }
    
    // Copia a imagem original para a nova imagem redimensionada
    imagecopyresampled($image_p, $image, 0, 0, 0, 0, $max_width, $max_height, $orig_width, $orig_height);
    
    // Salva a nova imagem redimensionada
    switch ($type) {
      case IMAGETYPE_JPEG:
        imagejpeg($image_p, $file_path, 80);
        break;
      case IMAGETYPE_PNG:
        imagepng($image_p, $file_path, 8);
        break;
      case IMAGETYPE_GIF:
        imagegif($image_p, $file_path);
        break;
      default:
        return false;
    }
    
    // Libera a memória utilizada
    imagedestroy($image);
    imagedestroy($image_p);
    
    return true;
}    

?>