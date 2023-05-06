<?php

namespace app\models;


class LogDenuncias extends Model
{

    protected $table = 'log_denuncias';

    //Retorna o chat de administradores do painel adm
    public function log($limit, $offset)
    {
        try {

            $query = "
                        SELECT
                            ld.*,
                            up.nickname
                        FROM 
                            {$this->table} AS ld
                        LEFT JOIN
                            user_perfil AS up
                        ON
                            ld.id_user_denunciante = up.id_user
                        ORDER BY 
                            ld.data
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