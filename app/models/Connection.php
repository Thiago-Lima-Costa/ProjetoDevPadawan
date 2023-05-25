<?php

namespace app\models;

use \PDO;
use \PDOException;


class Connection
{

    private static $pdo = null;

   
	public static function connect()
    {

        if(static::$pdo){

            return static::$pdo;

        } else {
		
            try {

                $config = include "../app/models/config.php"; 

                $pdo = new \PDO("mysql:host={$config['db']['host']};port={$config['db']['port']};dbname={$config['db']['dbname']};charset={$config['db']['charset']}", $config['db']['user'] , $config['db']['password']);
                $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                
                return $pdo;

            } catch (\PDOException $e) {

                $err = new \app\controllers\ErrorController($e);

            }


        }
	}
}

?>