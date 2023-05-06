<?php

namespace app\support;

class User
{

    public $user_id;
    public $email;
    public $nome;
    public $foto;
    public $nascimento;
    public $escolaridade;
    public $interesses;
    public $nivel_privilegio;
    public $banido;
    public $suspenso;
    

	public function __construct($id_user)
    {

        $userPerfil = new \app\models\UserPerfil();
        $userProfile = $userPerfil->findBy('id_user', $id_user);

        $userCadastro = new \app\models\UserCadastro();
        $userRegister = $userCadastro->findBy('id_user', $id_user);

        $userReputacao = new \app\models\UserReputacao();
        $userReputation = $userReputacao->findBy('id_user', $id_user);
          
        $this->__set('user_id', $id_user);
        $this->__set('email', $userRegister[0]['email']);
        $this->__set('nome', $userProfile[0]['nickname']);
        $this->__set('foto', ($userProfile[0]['foto'] != '') ? $userProfile[0]['foto'] : 'Assets/img/person.svg'); //Remover o valor pre definido apos criar um valor pre definido no BD
        $this->__set('nascimento', $userProfile[0]['data_nascimento']);
        $this->__set('escolaridade', $userProfile[0]['escolaridade']);
        $this->__set('interesses', explode(",", $userProfile[0]['interesses']));
        $this->__set('nivel_privilegio', $userProfile[0]['nivel_privilegio']);
        $this->__set('banido', $userReputation[0]['banido']);

        if($userReputation[0]['prazo_suspensao'] == NULL){
            $this->__set('suspenso', 0);
        } else if((\app\controllers\PenaltyController::isSuspended($userReputation[0]['prazo_suspensao'])) == false){
            $this->__set('suspenso', 0);
        } else if((\app\controllers\PenaltyController::isSuspended($userReputation[0]['prazo_suspensao'])) == true){
            $this->__set('suspenso', 1);
        }
		
	}

    public function __destruct()
    {
        
    }

    public function __get($attribute)
    {
        return $this->$attribute;
    }


    public function __set($attribute, $value)
    {
        $this->$attribute = $value;
    }

    public function validateSessionId(string $sessionId):bool
    {
        $data = decrypt($sessionId);

        $data = explode('@', $data);

        list($user_id, $email, $user_agent, $time) = $data;
        
        if($user_id != $_SESSION['user_id'] || $user_agent != $_SERVER['HTTP_USER_AGENT']) {
            header('Location: /logout');
            die();

        } else if ((time() - $time > 604800)) {
            header('Location: /logout');
            die();

        } else {
            return true;
        }
        
    }


}

?>