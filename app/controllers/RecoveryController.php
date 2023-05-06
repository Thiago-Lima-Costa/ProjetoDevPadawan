<?php

namespace app\controllers;

use app\support\EmailSender;
use app\support\Csrf;


class RecoveryController extends Controller
{   
    
    protected \app\support\EmailSender $sender;
    public $userEmail;
    public $recoverToken;

    public function index() {

        include("../app/views/contents/recoverView.php");

    }
    
    
    public function recoverPass() {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

			if (isset($_POST["recoverEmail"])) {

                $email = filter_input(INPUT_POST, 'recoverEmail', FILTER_SANITIZE_EMAIL);

                //Verifica se o email esta cadastrado
                $user = new \app\models\UserCadastro();
                $userExist = $user->counter('email', $email);

                if ($userExist[0]['count'] > 0) {

                    $token = uniqid().'-'.md5(time()).'-'.md5($email);

                    echo $token;

                    $this->sender = new EmailSender();

                    $to = $email;
                    $subject = "Recebemos sua solicitação de recuperação de senha";
                    $htmlContent = "<h1>Saudações Jovem Padawan!</h1></br></br><p>Nosso sistema recebeu uma solicitação de recuperação de senha, caso você não tenha solicitado a recuperação se sua senha ignore essa mensagem, ou, caso suspeite que está sendo vítima de uma tentativa de hacking entre em contato conosco.</p></br><p>Para escolher uma nova senha clique no link abaixo, ou recorte e cole no seu navegador.</p></br><a href= href=\"www.devpadawan.com/recover/{$token}\">www.devpadawan.com/recover/{$token}</a></br></br><p>Este link será válido por 48 horas.";
                    $textContent = "Saudações Jovem Padawan! /n Nosso sistema recebeu uma solicitação de recuperação de senha, caso você não tenha solicitado a recuperação se sua senha ignore essa mensagem, ou, caso suspeite que está sendo vítima de uma tentativa de hacking entre em contato conosco. /n Para escolher uma nova senha clique no link abaixo, ou recorte e cole no seu navegador. /n www.devpadawan.com/recover/{$token} /n /n Este link será válido por 48 horas.";
                    
                    $result = $this->sender->sendEmail($to, $subject, $htmlContent, $textContent);
                    if ($result === true) {
                        //Cria uma variavel SESSION que irá exibir um Modal no frontend
                        $_SESSION['recoverMessage'] = [
                        'title' => 'SOLICITAÇÃO ENVIADA',
                        'message' => 'Dentro de alguns minutos uma mensagem de recuperação de senha será enviada para o endereço informado. Caso não receba o e-mail verifique sua caixa de spam.',
                        'session_name' => 'recoverMessage',
                        'unset_variable' => true
                        ];

                        $AdmSenhas = new \app\models\AdmRecuperacaoSenhas();
                        $insert = ['email'=>$email, 'token'=>$token];
			            $AdmSenhas->insert($insert);

                        goBack();
                        die();
                        
                    } else {
                        //Cria uma variavel SESSION que irá exibir um Modal no frontend
                        $_SESSION['recoverMessage'] = [
                            'title' => 'HOUVE UM ERRO NO PROCESSAMENTO DE SUA SOLICITAÇÃO',
                            'message' => 'Por favor tente novamente depois de alguns minutos.',
                            'session_name' => 'recoverMessage',
                            'unset_variable' => true
                            ];
    
                            goBack();
                            die();

                    }     

                } else {
                    //Cria uma variavel SESSION que irá exibir um Modal no frontend
                    $_SESSION['recoverMessage'] = [
                        'title' => 'E-MAIL NÃO CADASTRADO',
                        'message' => 'Verifique o endereço de e-mail informado.',
                        'session_name' => 'recoverMessage',
                        'unset_variable' => true
                    ];

                    goBack();
                    die();
                }

            }
        }
    }

    public function recoverForm()
    {

        $token = $this->getUri();

        //Verifica se o email esta cadastrado
        $model = new \app\models\AdmRecuperacaoSenhas();
        $tokenExist = $model->counter('token', $token);

        if ($tokenExist[0]['count'] > 0) {

            $data = $model->findByToken($token);

            if ($data[0]['usado'] == true) {
                // O token já foi usado
                $msg = 'Este link já foi utilizado, por favor refaça a sua solicitação';
                $err = new \app\controllers\ErrorController($msg);
                die();
            }

            $tokenDatetime = strtotime($data[0]['data_solicitacao']);
            //Verifica se o token para recuperação de senha foi expedido a mais de 48h
            if ((time() - $tokenDatetime) > (48 * 3600)) {
                // Já se passaram mais de 48 horas
                $msg = 'Este link já expirou, por favor refaça a sua solicitação';
                $err = new \app\controllers\ErrorController($msg);
                die();
            } else {
                // Ainda não se passaram 48 horas
                $this->userEmail = $data[0]['email'];
                $this->recoverToken = $data[0]['token'];

                include("../app/views/contents/PasswordResetView.php");
            }

        } else {
            $err = new \app\controllers\ErrorController();
            die();
        }

    }

    public function passwordReset()
    {
        
        Csrf::validateToken();

		if (isset($_POST["pass1"]) && isset($_POST["pass2"]) && isset($_POST["token"]) && isset($_POST["email"])) {

            $pass1 = filter_input(INPUT_POST, 'pass1', FILTER_SANITIZE_STRING);
            $pass2 = filter_input(INPUT_POST, 'pass2', FILTER_SANITIZE_STRING);
            $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

            if ($pass1 != $pass2) {
                //Cria uma variavel SESSION que irá exibir um Modal no frontend
                $_SESSION['recoverMessage'] = [
                   'title' => 'ERRO NO PREENCHIMENTO',
                   'message' => 'As senhas informadas precisam ser iguais.',
                   'session_name' => 'recoverMessage',
                   'unset_variable' => true
               ];
               goBack();
               die();
           }

            if (!validateInput('password', $pass1) || !validateInput('password', $pass2)) {
                 //Cria uma variavel SESSION que irá exibir um Modal no frontend
                 $_SESSION['recoverMessage'] = [
                    'title' => 'INFORME UMA SENHA VÁLIDA',
                    'message' => 'A senha deve possuir entre 8 e 12 caracteres, deve possuir ao menos uma letra maiúscula, uma letra minúscula, um número e um dos seguintes caracteres especiais: !, @, #, $, %, ^, & ou *.',
                    'session_name' => 'recoverMessage',
                    'unset_variable' => true
                ];
                goBack();
                die();
            }

            //Verifica se o token esta cadastrado
            $model = new \app\models\AdmRecuperacaoSenhas();
            $data = $model->findByToken($token);

            if (!isset($data[0]['email']) && !isset($data[0]['token'])) {
                //Cria uma variavel SESSION que irá exibir um Modal no frontend
                $_SESSION['recoverMessage'] = [
                'title' => 'ERRO!',
                'message' => 'Houve um erro no processamento da sua solicitação.',
                'session_name' => 'recoverMessage',
                'unset_variable' => true
                ];
                goBack();
                die();
            }

            //Verifica mais uma vez se os dados informados via input hidden estao conforme os dados do BD
            if ($data[0]['email'] == $email && $data[0]['token'] == $token) {
     
                $model->update('usado', true, 'email', $email); //Inutiliza o token
                $passwordHash = password_hash($pass1, PASSWORD_DEFAULT);
                $user = new \app\models\UserCadastro();
                $user->update('senha', $passwordHash, 'email', $email);

                header('Location: /');
                die();

            } else {
                //Cria uma variavel SESSION que irá exibir um Modal no frontend
                $_SESSION['recoverMessage'] = [
                'title' => 'ERRO!',
                'message' => 'Houve um erro no processamento da sua solicitação, por favor preencha todos os campos e tente novamente.',
                'session_name' => 'recoverMessage',
                'unset_variable' => true
                ];
                goBack();
                die();
            }

        } else {
            //Cria uma variavel SESSION que irá exibir um Modal no frontend
            $_SESSION['recoverMessage'] = [
                'title' => 'ERRO!',
                'message' => 'Houve um erro no processamento da sua solicitação, por favor preencha todos os campos e tente novamente.',
                'session_name' => 'recoverMessage',
                'unset_variable' => true
            ];
            goBack();
            die();
        }

    }

    //RECUPERA A URI
	protected function getUri()
	{
		$uri = parse_url(filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL), PHP_URL_PATH);
        $uri = explode('/', $uri);
        return $uri[2];
	}
    
}

?>