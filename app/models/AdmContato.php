<?php

namespace app\models;


class AdmContato extends Model
{

    protected $table = 'adm_contato';

    //Retorna o chat de administradores do painel adm
    public function mostrarMensagens($limit, $offset)
    {
        try {

            $query = "
                        SELECT
                            *
                        FROM 
                            {$this->table}
                        ORDER BY 
                            data_contato
                        DESC 
                        LIMIT 
                            {$limit} 
                        OFFSET 
                            {$offset}";
            $list = $this->connection->prepare($query);
            $list->execute();

            return $list->fetchAll();

        } catch (\PDOException $e) {
            $err = new \app\controllers\ErrorController($e);
        }
    }

}


?>