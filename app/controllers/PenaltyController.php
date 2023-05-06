<?php

namespace app\controllers;
use app\support\Csrf;


class PenaltyController extends Controller
{   
    public \app\support\User $user;

    public function __construct()
	{
		if(isset($_SESSION['session_id']) && isset($_SESSION['user_id'])) {
			validateSessionId();
			$this->user = new \app\support\User($_SESSION['user_id']);
		}  else {
			$err = new \app\controllers\ErrorController();
            die();
		}

        if($this->user->nivel_privilegio <= 1) {
			$err = new \app\controllers\ErrorController();
            die();
		}
    }

    //Aplica uma advertencia
    public function advertir()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
			if (!empty($_POST['justificativa']) && !empty($_POST['nome_adm']) && !empty($_POST['id_user']) && !empty($_POST['nome_user']) && !empty($_POST['nivel_user'])) {

				$justificativa = filter_input(INPUT_POST, 'justificativa', FILTER_SANITIZE_STRING);
				$nome_adm = filter_input(INPUT_POST, 'nome_adm', FILTER_SANITIZE_STRING);
				$id_user = filter_input(INPUT_POST, 'id_user', FILTER_SANITIZE_STRING);
                $nome_user = filter_input(INPUT_POST, 'nome_user', FILTER_SANITIZE_STRING);
                $nivel_user = filter_input(INPUT_POST, 'nivel_user', FILTER_SANITIZE_STRING);

                if($nivel_user >= $this->user->nivel_privilegio){
                    goBack();
                    die();
                }

                $data = date("d/m/y");
                $texto = "Usuário {$nome_user} ADVERTIDO por {$nome_adm}, em {$data} - {$justificativa}";

                $insert = ['id_user'=>$id_user, 'tipo_penalidade'=>'Advertência', 'justificativa'=>$texto];

				$model = new \app\models\AdmHistoricoPenalidades();
				$model->insert($insert);

                $model2 = new \app\models\UserReputacao();
				$model2->sum('advertencias', $id_user);

                $model3 = new \app\models\AdmAvisos();
                $model3->criarAviso($texto, 'Sistema', 'info');
			}
		}
		goBack();
    }

    //Aplica uma suspensao
    public function suspender()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
			if (!empty($_POST['dias_suspensao']) && !empty($_POST['justificativa']) && !empty($_POST['nome_adm']) && !empty($_POST['id_user']) && !empty($_POST['nome_user']) && !empty($_POST['nivel_user'])) {
				$dias_suspensao = filter_input(INPUT_POST, 'dias_suspensao', FILTER_SANITIZE_STRING);
                $justificativa = filter_input(INPUT_POST, 'justificativa', FILTER_SANITIZE_STRING);
				$nome_adm = filter_input(INPUT_POST, 'nome_adm', FILTER_SANITIZE_STRING);
				$id_user = filter_input(INPUT_POST, 'id_user', FILTER_SANITIZE_STRING);
                $nome_user = filter_input(INPUT_POST, 'nome_user', FILTER_SANITIZE_STRING);
                $nivel_user = filter_input(INPUT_POST, 'nivel_user', FILTER_SANITIZE_STRING);

                if($nivel_user >= $this->user->nivel_privilegio){
                    goBack();
                    die();
                }

                $data = date("d/m/y");
                $texto = "Usuário {$nome_user} SUSPENSO por {$dias_suspensao} dias, aplicada por {$nome_adm}, em {$data} - {$justificativa}";

                $insert = ['id_user'=>$id_user, 'tipo_penalidade'=>'Suspensão', 'dias_penalidade'=>$dias_suspensao, 'justificativa'=>$texto];
				$model = new \app\models\AdmHistoricoPenalidades();
				$model->insert($insert);

                $prazo = new \DateTime();
                $prazo->modify("+{$dias_suspensao} days");
                $value = $prazo->format('Y-m-d');
                $model2 = new \app\models\UserReputacao();
                $model2->update('prazo_suspensao', $value, 'id_user', $id_user);
				$model2->sum('suspensoes', $id_user);

                $model3 = new \app\models\AdmAvisos();
                $model3->criarAviso($texto, 'Sistema', 'info');
			}
		}
		goBack();
    }

    //Bane um usuario
    public function banir()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (!empty($_POST['justificativa']) && !empty($_POST['nome_adm']) && !empty($_POST['id_user']) && !empty($_POST['nome_user']) && !empty($_POST['nivel_user'])) {
                $justificativa = filter_input(INPUT_POST, 'justificativa', FILTER_SANITIZE_STRING);
                $nome_adm = filter_input(INPUT_POST, 'nome_adm', FILTER_SANITIZE_STRING);
                $id_user = filter_input(INPUT_POST, 'id_user', FILTER_SANITIZE_STRING);
                $nome_user = filter_input(INPUT_POST, 'nome_user', FILTER_SANITIZE_STRING);
                $nivel_user = filter_input(INPUT_POST, 'nivel_user', FILTER_SANITIZE_STRING);

                if($nivel_user >= $this->user->nivel_privilegio){
                    goBack();
                    die();
                }

                $data = date("d/m/y");
                $texto = "Usuário {$nome_user} BANIDO por {$nome_adm}, em {$data} - {$justificativa}";

                $insert = ['id_user'=>$id_user, 'tipo_penalidade'=>'Banimento', 'justificativa'=>$texto];

                $model = new \app\models\AdmHistoricoPenalidades();
                $model->insert($insert);

                $model2 = new \app\models\UserReputacao();
                $model2->update('banido', 1, 'id_user', $id_user);

                $model3 = new \app\models\AdmAvisos();
                $model3->criarAviso($texto, 'Sistema', 'danger');

            }
        }
        goBack();
    }

    //Bane um usuario
    public function removerPenalidade()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (!empty($_POST['nome_adm']) && !empty($_POST['id_penalidade']) && !empty($_POST['penalidade']) && !empty($_POST['nome_user'])) {
                $nome_adm = filter_input(INPUT_POST, 'nome_adm', FILTER_SANITIZE_STRING);
                $id_penalidade = filter_input(INPUT_POST, 'id_penalidade', FILTER_SANITIZE_STRING);
                $penalidade = filter_input(INPUT_POST, 'penalidade', FILTER_SANITIZE_STRING);
                $nome_user = filter_input(INPUT_POST, 'nome_user', FILTER_SANITIZE_STRING);

                $data = date("d/m/y");
                $msg = "Usuário {$nome_user} teve uma {$penalidade} removida por {$nome_adm}, em {$data}";

                $model = new \app\models\AdmHistoricoPenalidades();
                $model->deleteAll('id', $id_penalidade);

                $model2 = new \app\models\AdmAvisos();
                $model2->criarAviso($msg, 'Sistema', 'info');
            }
        }
        goBack();
    }

    //Bane um usuario
    public function alterarNivelDeAcesso()
    {
        Csrf::validateToken();
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (!empty($_POST['nome_adm']) && !empty($_POST['id_user']) && !empty($_POST['nome_user']) && !empty($_POST['novo_nivel_user']) && (!empty($_POST['nivel_privilegio_atual']) || $_POST['nivel_privilegio_atual'] == 0)) {
                $nome_adm = filter_input(INPUT_POST, 'nome_adm', FILTER_SANITIZE_STRING);
                $id_user = filter_input(INPUT_POST, 'id_user', FILTER_SANITIZE_STRING);
                $nome_user = filter_input(INPUT_POST, 'nome_user', FILTER_SANITIZE_STRING);
                $novo_nivel_user = filter_input(INPUT_POST, 'novo_nivel_user', FILTER_SANITIZE_STRING);
                $nivel_privilegio_atual = filter_input(INPUT_POST, 'nivel_privilegio_atual', FILTER_SANITIZE_STRING);

                if($this->user->nivel_privilegio < 4){
                    goBack();
                    die();
                } elseif ($this->user->nivel_privilegio < $nivel_privilegio_atual) {
                    goBack();
                    die();
                }

                $data = date("d/m/y");
                $texto = "O usuário {$nome_user} recebeu uma nova credencial de acesso. Por {$nome_adm}, em {$data}";

                $model = new \app\models\UserPerfil();
                $model->update('nivel_privilegio', $novo_nivel_user, 'id_user', $id_user);

                $model2 = new \app\models\AdmAvisos();
                $model2->criarAviso($texto, 'Sistema', 'info');

            }
        }
        goBack();
    }
    
    //Verifica o prazo de uma suspensão e retorna 'true' se ainda estiver suspenso, e 'false' caso não haja uma supensão válida
    public static function isSuspended($prazo)
    {
        if($prazo != '') {
            $prazoSusp = new \DateTime($prazo);
        } else {
            $prazoSusp = new \DateTime();
        }

        $dataAtual = new \DateTime();
        $intervalo = $dataAtual->diff($prazoSusp);
        $dias = $intervalo->format('%R%a');
        
        if ($dias >= 1) {
            return true;
        } else {
            return false;
        }
    }
}

?>