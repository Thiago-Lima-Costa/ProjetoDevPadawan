<?php

namespace app\models;


class Artigos extends Model
{

    protected $table = 'artigos';
   

    //BUSCA OS ULTIMOS ARTIGOS PARA EXIBICAO NO INDEX
    public function lastArticles()
    {

        $query = "
                    SELECT
                        id_artigo,
                        titulo_artigo,
                        subtitulo_artigo,
                        SUBSTRING(introducao_artigo, 1, 300) AS texto,
                        data_artigo,
                        img_artigo_miniatura
                    FROM
                        {$this->table}
                    ORDER BY 
                        data_artigo DESC
                    LIMIT 
                        6
                ";
        $list = $this->connection->prepare($query);
        $list->execute();

        return $list->fetchAll(\PDO::FETCH_ASSOC);

    }


    //BUSCA OS ULTIMOS ARTIGOS PARA EXIBICAO NO INDEX
    public function blog($limit, $offset)
    {

        $query = "
                SELECT
                    id_artigo,
                    categoria,
                    titulo_artigo,
                    subtitulo_artigo,
                    SUBSTRING(introducao_artigo, 1, 300) AS subs_texto,
                    data_artigo,
                    img_artigo_miniatura
                FROM
                    {$this->table}
                ORDER BY 
                    data_artigo DESC
                LIMIT
                    {$limit}
                OFFSET
                    {$offset}
                ";
        $list = $this->connection->prepare($query);
        $list->execute();

        return $list->fetchAll(\PDO::FETCH_ASSOC);

    }


    //RETORNA OS DADOS DO ARTIGO PARA EXIBICAO
    public function article($id_article)
    {

        $query = "
                SELECT
                    id_artigo,
                    categoria,
                    titulo_artigo,
                    subtitulo_artigo,
                    introducao_artigo,
                    desenvolvimento_artigo,
                    conclusao_artigo,
                    data_artigo,
                    id_autor,
                    user_perfil.nickname AS autor,
                    img_artigo
                FROM
                    {$this->table}
                JOIN
                    user_perfil
                ON
                    {$this->table}.id_autor = user_perfil.id_user
                WHERE
                    id_artigo = {$id_article}
                ";
        $list = $this->connection->prepare($query);
        $list->execute();

        return $list->fetchAll(\PDO::FETCH_ASSOC);

    }


    public function addAccess($id_artigo)
    {
        try {

            $query = "UPDATE {$this->table} SET acessos = acessos + 1 WHERE id_artigo = :id_artigo";
            $stmt = $this->connection->prepare($query);
            $stmt->bindValue(':id_artigo', $id_artigo);
            $stmt->execute();

            return $stmt->rowCount();

        } catch (\PDOException $e) {
            $err = new \app\controllers\ErrorController($e);
        }
    }

    //RETORNA A LISTA DE ARTIGOS DE UM COLABORADOR
    public function listaPaginada($id, $limit, $offset)
    {

        $query = "
                SELECT
                    a.id_artigo,
                    a.titulo_artigo,
                    a.subtitulo_artigo,
                    a.id_autor,
                    a.data_artigo,
                    up.nickname AS nome_autor
                FROM
                    {$this->table} AS a
                LEFT JOIN
                    user_perfil AS up
                ON
                    a.id_autor = up.id_user
                WHERE
                   a.id_autor = {$id}
                ORDER BY 
                    data_artigo DESC
                LIMIT
                    {$limit}
                OFFSET
                    {$offset}
                ";
        $list = $this->connection->prepare($query);
        $list->execute();

        return $list->fetchAll(\PDO::FETCH_ASSOC);

    }


    //RETORNA A LISTA DE ARTIGOS DE UM COLABORADOR
    public function recuperaArtigo($id_user, $id_artigo)
    {

        $query = "
                SELECT
                    a.*,
                    up.nickname AS nome_autor
                FROM
                    {$this->table} AS a
                LEFT JOIN
                    user_perfil AS up
                ON
                    a.id_autor = up.id_user
                WHERE
                   a.id_autor = {$id_user} AND a.id_artigo = {$id_artigo}
                ";
        $list = $this->connection->prepare($query);
        $list->execute();

        return $list->fetchAll(\PDO::FETCH_ASSOC);

    }

}


?>