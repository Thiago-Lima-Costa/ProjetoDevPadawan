<?php

namespace app\models;


class AdmHistoricoPenalidades extends Model
{

    protected $table = 'adm_historico_penalidades';


    //Retorna o historico de penalidades aplicadas
    public function historico($limit, $offset)
    {
        try {

            $query = "SELECT ahp.id_user, ahp.tipo_penalidade, ahp.data_penalidade, ahp.dias_penalidade, up.nickname, up.foto, up.nivel_privilegio, ur.prazo_suspensao, ur.banido FROM {$this->table} AS ahp INNER JOIN user_perfil AS up ON ahp.id_user = up.id_user LEFT JOIN user_reputacao AS ur ON ahp.id_user = ur.id_user ORDER BY ahp.data_penalidade DESC LIMIT {$limit} OFFSET {$offset}";
            $list = $this->connection->prepare($query);
            $list->execute();

            return $list->fetchAll();

        } catch (\PDOException $e) {
            $err = new \app\controllers\ErrorController($e);
        }
    }

    //Retorna o historico de penalidades aplicadas
    public function historicoDoUsuario($user)
    {
        try {

            $query = "SELECT ahp.id, ahp.id_user, ahp.tipo_penalidade, ahp.data_penalidade, ahp.dias_penalidade, up.nickname, up.foto, up.nivel_privilegio, ur.prazo_suspensao, ur.banido FROM {$this->table} AS ahp INNER JOIN user_perfil AS up ON ahp.id_user = up.id_user LEFT JOIN user_reputacao AS ur ON ahp.id_user = ur.id_user WHERE LOWER(up.nickname) = LOWER(?) ORDER BY ahp.data_penalidade DESC";
            $list = $this->connection->prepare($query);
            $list->bindValue(1, $user);
            $list->execute();

            return $list->fetchAll();

        } catch (\PDOException $e) {
            $err = new \app\controllers\ErrorController($e);
        }
    }

}


?>