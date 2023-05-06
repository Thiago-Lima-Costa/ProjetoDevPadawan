<?php

namespace app\models;


class UserPerfil extends Model
{

    protected $table = 'user_perfil';

    //Atualiza no BD as altereções no perfil realizadas pelo proprio usuario
    function updateProfile($field, $value, $user_id)
    {
		
		switch ($field) { 
			case "foto":
				$this->update($field, $value, 'id_user', $user_id);
				break;

			case "escolaridade":
				$this->update($field, $value, 'id_user', $user_id);
				break;

			case "data_nascimento":
				$data = new \DateTime($value);
				$dataFormatada = $data->format('Y-m-d');
				$this->update($field, $dataFormatada, 'id_user', $user_id);
				break;

			case "interesses":
				$this->update($field, $value, 'id_user', $user_id);
				break;

			default:
				$err = new \app\controllers\ErrorController();
				exit;
		}

    }

	//Lista paginada de usuarios
	public function listaPaginada($limit, $offset)
	{
		$query = "
				SELECT
					up.id_user,
					up.nickname,
					up.foto,
					up.nivel_privilegio,
					ur.banido,
					ur.prazo_suspensao
				FROM 
					{$this->table} AS up
				LEFT JOIN
					user_reputacao As ur
				ON 
					up.id_user = ur.id_user
				ORDER BY
					up.nickname 
				ASC
				LIMIT
					{$limit}
				OFFSET 
					{$offset}
				";
		$list = $this->connection->prepare($query);
		$list->execute();

		return $list->fetchAll();
	}

	//Busca usuarios para o painel adm listar usuarios
	public function buscaUsuario($user)
	{
		$query = "
				SELECT
					up.id_user,
					up.nickname,
					up.foto,
					up.nivel_privilegio,
					ur.banido,
					ur.prazo_suspensao
				FROM 
					{$this->table} AS up
				LEFT JOIN
					user_reputacao As ur
				ON 
					up.id_user = ur.id_user
				WHERE
					LOWER(up.nickname) = LOWER(?)
				ORDER BY
					up.nickname 
				ASC
				";
		$list = $this->connection->prepare($query);
		$list->bindValue(1, $user);
		$list->execute();

		return $list->fetchAll();
	}

	//Busca usuarios para o painel adm aplicar e remover punicoes
	public function historicoUsuario($user)
	{
		$query = "
				SELECT
					up.id_user,
					up.nickname,
					up.foto,
					up.nivel_privilegio,
					ur.advertencias,
					ur.suspensoes,
					ur.banido,
					ur.prazo_suspensao
				FROM 
					{$this->table} AS up
				LEFT JOIN
					user_reputacao AS ur
				ON 
					up.id_user = ur.id_user
				WHERE
					LOWER(up.nickname) = LOWER(?)
				GROUP BY
					up.id_user
				ORDER BY
					up.nickname 
				ASC
				";
		$list = $this->connection->prepare($query);
		$list->bindValue(1, $user);
		$list->execute();

		return $list->fetchAll();
	}

	//Busca usuarios para o painel adm aplicar e remover punicoes
	public function equipe()
	{
		$query = "
				SELECT
					*
				FROM 
					{$this->table}
				WHERE
					nivel_privilegio >= 2
				ORDER BY
					nickname 
				ASC
				";
		$list = $this->connection->prepare($query);
		$list->execute();

		return $list->fetchAll();
	}

}


?>