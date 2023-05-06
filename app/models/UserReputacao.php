<?php

namespace app\models;


class UserReputacao extends Model
{

    protected $table = 'user_reputacao';

    public function sum($campo, $id_user)
    {
        try {

            $query = "UPDATE {$this->table} SET {$campo} = {$campo} + 1 WHERE id_user = :id_user";
            $stmt = $this->connection->prepare($query);
            $stmt->bindValue(':id_user', $id_user);
            $stmt->execute();

            return $stmt->rowCount();

        } catch (\PDOException $e) {
            $err = new \app\controllers\ErrorController($e);
        }
    }

    public function subtraction($campo, $id_user)
    {
        try {

            $query = "UPDATE {$this->table} SET {$campo} = {$campo} - 1 WHERE id_user = :id_user";
            $stmt = $this->connection->prepare($query);
            $stmt->bindValue(':id_user', $id_user);
            $stmt->execute();

            return $stmt->rowCount();

        } catch (\PDOException $e) {
            $err = new \app\controllers\ErrorController($e);
        }
    }


}


?>