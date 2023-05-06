<?php

namespace app\models;


class Forum extends Model
{

    protected $table = 'forum';

    //Retorna a lista de foruns
    public function foruns()
    {

        $query = "
                SELECT 
                    forum.nome_forum,
                    forum.id_forum,
                    forum.forum_descricao,
                    subquery.userimage,
                    subquery.topico,
                    SUBSTRING(subquery.topico, 1, 19) AS topico_sub,
                    subquery.username,
                    subquery.ultima_postagem,
                    COUNT(forum_topico_postagem.id_postagem) AS posts_amount
                FROM 
                    {$this->table} AS forum
                RIGHT JOIN (
                    SELECT
                        F.id_forum,
                        FT.nome_topico AS topico,
                        FT.id_topico AS id_topico,
                        MAX(FTP.data_postagem) AS ultima_postagem,
                        U.nickname AS username,
                        U.foto AS userimage
                    FROM
                        {$this->table} AS F
                    LEFT JOIN 
                        forum_topico AS FT 
                    ON 
                        FT.id_forum = F.id_forum
                    LEFT JOIN 
                        forum_topico_postagem AS FTP 
                    ON 
                        FTP.id_topico = FT.id_topico
                    INNER JOIN 
                        user_perfil AS U 
                    ON 
                        U.id_user = FTP.id_user
                    GROUP BY
                        F.id_forum,
                        FT.id_topico,
                        U.id_user
                    HAVING
                        MAX(FTP.data_postagem) = (
                            SELECT
                                MAX(FTP2.data_postagem)
                            FROM
                                forum_topico_postagem AS FTP2
                            WHERE
                                FTP2.id_topico = FT.id_topico
                        )
                    ORDER BY 
                        ultima_postagem DESC ) AS subquery
                ON 
                    forum.id_forum = subquery.id_forum
                LEFT JOIN
                    forum_topico_postagem
                ON
                    forum_topico_postagem.id_topico = subquery.id_topico
                GROUP BY
                    forum.id_forum
                ORDER BY 
                    subquery.ultima_postagem DESC
                ";

        $list = $this->connection->prepare($query);
        $list->execute();

        return $list->fetchAll(\PDO::FETCH_ASSOC);

    }


}


?>



