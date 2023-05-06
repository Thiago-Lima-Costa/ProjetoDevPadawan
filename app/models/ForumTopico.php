<?php

namespace app\models;


class ForumTopico extends Model
{

    protected $table = 'forum_topico';


    public function getTopicos($forum_id)
    {

        $query = "
			select 
				*
			from 
                {$this->table}
			left join
                forum
            on 
                {$this->table}.id_forum = forum.id_forum
            where
                forum.id_forum = :id_forum
            order by
                {$this->table}.data_topico desc	
		";

        $list = $this->connection->prepare($query);
        $list->bindValue(':id_forum', $forum_id);
        $list->execute();

        return $list->fetchAll();

    }


    //BUSCA AS ULTIMAS POSTAGENS DE CADA FORUM PARA EXIBICAO NO INDEX
    public function samplePosts()
    {

        $query = "
                    SELECT
                        user1.nickname AS user1nickname,
                        ft.nome_topico,
                        ft.id_topico,
                        ft.data_topico,
                        f.nome_forum,
                        ft.visualizacoes,
                        user2.nickname AS user2nickname,
                        user2.foto AS user2foto,
                        ftp.data_postagem
                    FROM
                        {$this->table} AS ft
                    LEFT JOIN 
                        user_perfil AS user1
                    ON 
                        ft.id_user = user1.id_user 
                    LEFT JOIN 
                        forum_topico_postagem AS ftp
                    ON 
                        ft.id_topico = ftp.id_topico
                    LEFT JOIN 
                        forum AS f
                    ON 
                        ft.id_forum = f.id_forum
                    LEFT JOIN 
                        user_perfil AS user2
                    ON 
                        ftp.id_user = user2.id_user
                    GROUP BY 
                        ft.id_topico
                    ORDER BY 
                        ftp.data_postagem DESC
                    LIMIT 
                        10 
                ";
        $list = $this->connection->prepare($query);
        $list->execute();

        return $list->fetchAll(\PDO::FETCH_ASSOC);

    }

    //BUSCA OS TOPICOS DE UM FORUM ORDNADO PELAS ULTIMAS POSTAGENS
    public function topics($id_forum, $limit, $offset)
    {

        $query = "
                    SELECT
                        ft.nome_topico,
                        ft.texto_topico,
                        SUBSTRING(ft.texto_topico, 1, 98) AS subs_texto_topico,
                        ft.id_topico,
                        ft.data_topico,
                        ft.visualizacoes,
                        user.nickname,
                        user.foto,
                        COUNT(ftp.id_postagem) AS posts_amount
                    FROM
                        {$this->table} AS ft
                    LEFT JOIN 
                        user_perfil AS user
                    ON 
                        ft.id_user = user.id_user
                    LEFT JOIN
                        forum_topico_postagem AS ftp
                    ON 
                        ft.id_topico = ftp.id_topico
                    WHERE 
                        ft.id_forum = {$id_forum}
                    GROUP BY 
                        ft.id_topico
                    ORDER BY 
                        ftp.data_postagem DESC
                    LIMIT
                        {$limit}
                    OFFSET
                        {$offset}
                ";
        $list = $this->connection->prepare($query);
        $list->execute();

        return $list->fetchAll(\PDO::FETCH_ASSOC);

    }


    //RETORNA UM TOPICO ESPECIFICO
    public function getTopic($id_topic)
    {

        $query = "
                    SELECT
                        ft.id_topico,
                        ft.id_forum,
                        ft.id_user,
                        ft.data_topico,
                        ft.bloqueado,
                        ft.data_bloqueio,
                        ft.adm_bloqueio,
                        ft.ativo,
                        ft.nome_topico,
                        ft.texto_topico,
                        ft.visualizacoes,
                        user.nickname,
                        user.foto,
                        COUNT(ftp.id_postagem) AS posts_amount
                    FROM
                        {$this->table} AS ft
                    LEFT JOIN 
                        user_perfil AS user
                    ON 
                        ft.id_user = user.id_user
                    LEFT JOIN
                        forum_topico_postagem AS ftp
                    ON 
                        ft.id_topico = ftp.id_topico
                    WHERE 
                        ft.id_topico = {$id_topic}
                ";
        $list = $this->connection->prepare($query);
        $list->execute();

        return $list->fetchAll(\PDO::FETCH_ASSOC);

    }


}


?>