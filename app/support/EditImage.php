<?php

namespace app\support;

class EditImage
{
    //Recebe como parametro um arquivo contido na superglobal $_FILES[]
    static function uploadImage($file, $sizeX, $sizeY, $name, $dir)
    {
        $fileName = $file['name'];
        $fileType = $file['type'];
        $fileSize = $file['size'];
        $fileTmpName = $file['tmp_name'];
        $fileError = $file['error'];

        if ($fileError !== UPLOAD_ERR_OK || $fileTmpName == '') {
            return false;
        }

		//Verifica a extensao e limita o tipo da imagem à jpeg, jpg e png
		$extension = pathinfo($fileName, PATHINFO_EXTENSION); 
		if ($extension != 'jpeg' && $extension != 'jpg' && $extension != 'png') {
			return false;
		}

		// Define o novo nome do arquivo e a pasta de destino
		$destination = __DIR__.'/../../public/Assets/img/'.$dir.'/'.$name.'.'.$extension;

		//Salva a nova imagem do usuario 
		move_uploaded_file($fileTmpName, $destination);
		//Chama a funcao resizeImage
		self::resizeImage($destination, $sizeX, $sizeY);

		//Retorna um nome da imagem para ser salvo no BD
		$imagePathForDB = 'Assets/img/'.$dir.'/'.$name.'.'.$extension;
		return $imagePathForDB;
	}

	//Altera o tamanho de uma imagem
	static function resizeImage($file_path, $max_width, $max_height)
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



}

?>