<?php

namespace app\models;


class AdmRecuperacaoSenhas extends Model
{

    protected $table = 'adm_recuperacao_senha';


    //BUSCA POR UMA TUPLA ESPECIFICA NA TABELA
    public function findByToken($value)
    {
        try {

            $query = "SELECT * FROM {$this->table} WHERE `token` = ?";
            $list = $this->connection->prepare($query);
            $list->bindValue(1, $value);
            $list->execute();

            return $list->fetchAll();

        } catch (\PDOException $e) {
            $err = new \app\controllers\ErrorController($e);
        }
    }

}


?>