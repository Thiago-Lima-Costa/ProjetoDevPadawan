<?php

namespace app\models;


class ForumTopicoPostagem extends Model
{

    protected $table = 'forum_topico_postagem';


    //CONTA O NUMERO DE POSTAGENS DE UM TOPICO
    public function countPosts($id_topic)
    {

        $query = "
                    SELECT
                        COUNT('id_topico') AS total
                    FROM
                        {$this->table}
                    WHERE
                        id_topico = {$id_topic}
                ";
        $count = $this->connection->prepare($query);
        $count->execute();

        return $count->fetchAll(\PDO::FETCH_ASSOC);

    }

    //RETORNA OS POSTS DE UM TOPICO
    public function getPosts($id_topic, $limit, $offset)
    {

        $query = "
                    SELECT
                        ftp.id_postagem,
                        ftp.id_topico,
                        ftp.id_user,
                        ftp.data_postagem,
                        ftp.texto_postagem,
                        ftp.img_postagem,
                        ftp.resposta,
                        ftp.id_postagem_referencia,
                        user.nickname,
                        user.foto,
                        SUBSTRING(referencia.texto_postagem, 1, 97) AS subs_texto_referencia,
                        referencia.texto_postagem AS texto_referencia,
                        referencia.data_postagem AS data_referencia,
                        referencia.id_user AS id_user_referencia,
                        user_referencia.nickname AS username_referencia,
                        user_referencia.foto AS user_img_referencia
                    FROM
                        {$this->table} AS ftp
                    LEFT JOIN 
                        user_perfil AS user
                    ON 
                        ftp.id_user = user.id_user
                    LEFT JOIN
                        forum_topico_postagem AS referencia
                    ON
                        ftp.id_postagem_referencia = referencia.id_postagem          
                    LEFT JOIN
                        user_perfil AS user_referencia
                    ON
                        referencia.id_user = user_referencia.id_user     
                    WHERE 
                        ftp.id_topico = {$id_topic}
                    ORDER BY 
                        ftp.data_postagem ASC
                    LIMIT
                        {$limit}
                    OFFSET
                        {$offset}
                ";

        $list = $this->connection->prepare($query);
        $list->execute();

        return $list->fetchAll(\PDO::FETCH_ASSOC);

    }

}


?>