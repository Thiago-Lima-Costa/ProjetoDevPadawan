<?php

namespace app\models;
use app\models\Connection;


abstract class Model
{

    protected $connection;


    public function __construct()
    {
        $this->connection = Connection::connect();   
    }


    public function __get($attribute)
    {
        return $this->$attribute;
    }


    public function __set($attribute, $value)
    {
        $this->$attribute = $value;
    }


    //BUSCA TODOS OS REGISTROS DA TABELA
    public function all()
    {
        try {

            $query = "SELECT * FROM {$this->table}";
            $list = $this->connection->prepare($query);
            $list->execute();

            return $list->fetchAll();

        } catch (\PDOException $e) {
            $err = new \app\controllers\ErrorController($e);
        }
    }

    //BUSCA POR UMA TUPLA ESPECIFICA NA TABELA
    public function findBy($field, $value)
    {
        try {

            $query = "SELECT * FROM {$this->table} WHERE LOWER({$field}) = LOWER(?)";
            $list = $this->connection->prepare($query);
            $list->bindValue(1, $value);
            $list->execute();

            return $list->fetchAll();

        } catch (\PDOException $e) {
            $err = new \app\controllers\ErrorController($e);
        }
    }

    //BUSCA POR UM VALOR ESPECIFICO NA TABELA
    public function find($fetched, $field, $value)
    {
        try {

            $query = "SELECT {$fetched} FROM {$this->table} WHERE {$field} = ?";
            $list = $this->connection->prepare($query);
            $list->bindValue(1, $value);
            $list->execute();

            $return = $list->fetchAll();
            $return = $return[0][0];

            return $return;

        } catch (\PDOException $e) {
            $err = new \app\controllers\ErrorController($e);
        }
    }

    //BUSCA POR UMA VALOR ESPECIFICO NA TABELA E RETORNA O CONTADOR
    public function counter($field, $value)
    {
        try {

            $query = "SELECT COUNT(*) AS count FROM {$this->table} WHERE {$field} = ?";
            $count = $this->connection->prepare($query);
            $count->bindValue(1, $value);
            $count->execute();

            return $count->fetchAll();

        } catch (\PDOException $e) {
            $err = new \app\controllers\ErrorController($e);
        }
    }


    //APAGA UMA TUPLA DA TABELA
    public function deleteAll($field, $value)
    {
        try {

            $query = "DELETE FROM {$this->table} WHERE {$field} = ?";
            $delete = $this->connection->prepare($query);
            $delete->bindValue(1, $value);
            $delete->execute();

            return $delete->rowCount();

        } catch (\PDOException $e) {
            $err = new \app\controllers\ErrorController($e);
        }
    }


    //INSERE VALORES NA TABELA, DEVE RECEBER COMO PARAMETRO UM ARRAY ASSOCIATIVO ONDE AS CHAVES DEVEM SER NOMEADAS COM OS NOMES DAS COLUNAS DA TABELA
    public function insert(array $attributes)
    {
        try {

            $query = "INSERT INTO {$this->table} (";
            $query .= implode(',', array_keys($attributes)) . ") VALUES (";
            $query .= ":" . implode(', :', array_keys($attributes)) . ")";

            $stmt = $this->connection->prepare($query);

            foreach ($attributes as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            
            $stmt->execute();

            return $this;  
            
        } catch (\PDOException $e) {
            $err = new \app\controllers\ErrorController($e);
        }
    }

    //ALTERA DADOS NA TABELA
    public function update($attribute, $value, $filter, $filterValue)
    {
        try {

            $query = "UPDATE {$this->table} SET {$attribute} = ? WHERE {$filter} = ?";
			$update = $this->connection->prepare($query);
			$update->bindValue(1, $value);
            $update->bindValue(2, $filterValue);
			$update->execute();
			return $update->rowCount();

        } catch (\PDOException $e) {
            $err = new \app\controllers\ErrorController($e);
        }
    }

    //ALTERA VARIOS CAMPOS DA TABELA AO MESMO TEMPO O PARAMETRO $ATTRIBUTES DEVE SER UM ARRAY ASSOCIATIVO ONDE AS CHAVES DEVEM SER NOMEADAS COM OS NOMES DAS COLUNAS DA TABELA
    //OBSERVAR SE ESSA FUNCAO POSSUI UTILIDADE
    public function updateMultiples(array $attributes, string $filter, string|int $filterValue)
    {
        try {

            $query = "UPDATE {$this->table} SET "; 
        
            foreach ($attributes as $key => $value ) {
                $query .= "{$key} = :{$key}, ";
            }

            $query = rtrim($query, ', ');

            $query .= " WHERE {$filter} = {$filterValue}";

            $update = $this->connection->prepare($query);

            foreach ($attributes as $key => $value) {
                $update->bindValue($key, $value);
            }

            $update->execute();

            return $update->rowCount();

        } catch (\PDOException $e) {
            $err = new \app\controllers\ErrorController($e);
        }
    }

}



?>