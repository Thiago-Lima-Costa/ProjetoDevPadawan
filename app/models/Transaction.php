<?php

namespace app\models;


class Transaction extends Model
{

    //ESTE METODO POSSUI A FUNCAO ESPECIFICA DE FINALIZAR O CADASTRO DE NOVOS USUARIOS, INSERINDO SEUS DADOS NO BD. DEVE RECEBER COMO PARAMETROS O EMAIL, A SENHA AINDA NAO CRIPTOGRAFADA E O NOME DO USUARIO
    public function finalizeRegister(string $email, string $password, string $userName) {

        try {
            // Inicia a Transaction
            $this->connection->beginTransaction();
    
            // Executa as insercoes nas tabelas user_cadastro, user_perfil e user_reputacao
            $query = "INSERT INTO user_cadastro (email, senha) VALUES (:email, :senha)";
            $stmt = $this->connection->prepare($query);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':senha', password_hash($password, PASSWORD_DEFAULT));
            $stmt->execute();
    
            $query = "INSERT INTO user_perfil (id_user, nickname) VALUES (LAST_INSERT_ID(), :nickname)";
            $stmt = $this->connection->prepare($query);
            $stmt->bindValue(':nickname', $userName);
            $stmt->execute();
    
            $query = "INSERT INTO user_reputacao (id_user) VALUES (LAST_INSERT_ID())";
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
    
            // Se tudo der certo, confirma a transacao
            $this->connection->commit();

        } catch (Exception $e) {
            // Em caso de erro desfaz a transacao
            $this->connection->rollBack();

            $err = new \app\controllers\ErrorController($e);
        }
    }

}


?>