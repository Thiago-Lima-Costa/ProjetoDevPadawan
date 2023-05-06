<?php

namespace app\controllers;


class MarketingController extends Controller
{   
	//CRIAR ARQUIVOS CONTENDO OS ANUNCIOS ADS E AFILIADOS PARA QUE O METODO INSIRA ESSES ARQUIVOS NA PAGINA ATRAVES DE INCLUDE()
    public static function randomVerticalAd() {
        $randomValue = random_int(1, 100);

        if ($randomValue <= 25) {
            return include '../app/views/partials/...../......php';
        } elseif ($randomValue >= 26 && $randomValue <= 50) {
            return include '../app/views/partials/...../......php';
        } elseif ($randomValue >= 51 && $randomValue <= 75) {
            return include '../app/views/partials/...../......php';
        } elseif ($randomValue >= 76 && $randomValue <= 100) {
            return include '../app/views/partials/...../......php';
        }
    }

    public static function randomHorizontalAd() {
        $randomValue = random_int(1, 100);

        if ($randomValue <= 25) {
            return include '../app/views/partials/...../......php';
        } elseif ($randomValue >= 26 && $randomValue <= 50) {
            return include '../app/views/partials/...../......php';
        } elseif ($randomValue >= 51 && $randomValue <= 75) {
            return include '../app/views/partials/...../......php';
        } elseif ($randomValue >= 76 && $randomValue <= 100) {
            return include '../app/views/partials/...../......php';
        }
    }

}




?>