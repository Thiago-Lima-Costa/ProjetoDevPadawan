<?php

namespace app\models;


class AdmMsgAdm extends Model
{

    protected $table = 'adm_msg_adm';


    //Retorna o chat de administradores do painel adm
    public function chatAdm($limit, $offset)
    {
        try {

            $query = "
                        SELECT
                            ama.id,
                            ama.data_msg,
                            ama.id_adm,
                            ama.nome_adm,
                            ama.mensagem,
                            ama.resposta,
                            ama.id_postagem_referencia,
                            SUBSTRING(referencia.mensagem, 1, 20) AS subs_texto_referencia,
                            referencia.nome_adm AS nome_referencia,
                            referencia.data_msg AS data_referencia
                        FROM 
                            {$this->table} AS ama
                        LEFT JOIN
                            {$this->table} AS referencia
                        ON
                            ama.id_postagem_referencia = referencia.id
                        ORDER BY 
                            data_msg 
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

    //Retorna os avisos do painel adm
    public function enviarMensagem($mensagem, $id_adm, $nome_adm, $resposta=0, $id_referencia=null)
    {
        try {

            $query = "INSERT INTO {$this->table}(id_adm, nome_adm, mensagem, resposta, id_postagem_referencia) VALUES (:id_adm, :nome_adm, :mensagem, :resposta, :id_postagem_referencia)";
            $list = $this->connection->prepare($query);
            $list->bindValue(':id_adm', $id_adm);
            $list->bindValue(':nome_adm', $nome_adm);
            $list->bindValue(':mensagem', $mensagem);
            $list->bindValue(':resposta', $resposta);
            $list->bindValue(':id_postagem_referencia', $id_referencia);
            $list->execute();

            return $list->fetchAll();

        } catch (\PDOException $e) {
            $err = new \app\controllers\ErrorController($e);
        }
    }

}


?>