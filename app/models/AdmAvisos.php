<?php

namespace app\models;


class AdmAvisos extends Model
{

    protected $table = 'adm_avisos';


    //Retorna os avisos do painel adm
    public function avisosDoSistema($limit, $offset)
    {
        try {

            $query = "SELECT * FROM {$this->table} WHERE data_aviso >= DATE_SUB(NOW(), INTERVAL 1 MONTH) ORDER BY data_aviso DESC LIMIT {$limit} OFFSET {$offset}";
            $list = $this->connection->prepare($query);
            $list->execute();

            return $list->fetchAll();

        } catch (\PDOException $e) {
            $err = new \app\controllers\ErrorController($e);
        }
    }

    //Retorna os avisos do painel adm
    public function criarAviso($msg, $autor='Sistema', $tipo='info')
    {
        try {

            $query = "INSERT INTO {$this->table}(aviso, tipo, autor) VALUES (?, ?, ?)";
            $list = $this->connection->prepare($query);
            $list->bindValue(1, $msg);
            $list->bindValue(2, $tipo);
            $list->bindValue(3, $autor);
            $list->execute();

            return $list->fetchAll();

        } catch (\PDOException $e) {
            $err = new \app\controllers\ErrorController($e);
        }
    }

}


?>