<?php

namespace app\controllers;



class ForumController extends Controller
{

	use \app\traits\Paginate;

    public array $view = [
		'header' => 'BaseHeader',
		'content' => 'ShowForunsView',
		'footer' => 'BaseFooter'
	];
    
    
	public \app\support\User $user;

	public array $foruns;
	public array $forum_values;
	public array $topics_values;
	public array $posts_values;
	protected string $uri;

	//EXIBE A LISTA DOS FÓRUNS EXISTENTES
    public function index()
    {
		$this->view = [
			'header' => 'BaseHeader',
			'content' => 'ShowForunsView',
			'footer' => 'BaseFooter'
		];

		if(isset($_SESSION['session_id']) && isset($_SESSION['user_id'])) {
			validateSessionId();
			$this->user = new \app\support\User($_SESSION['user_id']);
		}

		$foruns = new \app\models\Forum();
		$this->foruns = $foruns->foruns();
		$this->render();
    }

	//EXIBE O CONTEUDO E TOPICOS DE UM FORUM ESPECIFICO (JAVA OU PHP OU JS...)
	public function forum()
    {
		try {

			if(isset($_SESSION['session_id']) && isset($_SESSION['user_id'])) {
				validateSessionId();
				$this->user = new \app\support\User($_SESSION['user_id']);
			}

			$this->view = [
				'header' => 'BaseHeader',
				'content' => 'ForumView',
				'footer' => 'BaseFooter'
			];

			$this->getUri();
			$uri2 = explode('/', $this->uri);
			$forumId = explode('-', $uri2[2]);

			$this->setCurrentPage();

			$forum = new \app\models\Forum();
			$this->forum_values = $forum->findBy('id_forum', $forumId[0]);
			
			$topics = new \app\models\ForumTopico();
			$this->topics_values = $topics->topics($this->forum_values[0]['id_forum'], $this->perPage, $this->offset);
			
			$amount = $topics->counter('id_forum', $this->forum_values[0]['id_forum']);

			$this->setTotalPages($amount[0]['count']);

			$this->render();

		} catch (Exception $e) {
			$err = new \app\controllers\ErrorController($e);
		}	
	}

	//EXIBE O CONTEUDO E AS POSTAGENS DE UM TOPICO ESPECIFICO
	public function showTopic()
    {
		if(isset($_SESSION['session_id']) && isset($_SESSION['user_id'])) {
			validateSessionId();
			$this->user = new \app\support\User($_SESSION['user_id']);
		}

		$this->view = [
			'header' => 'BaseHeader',
			'content' => 'TopicView',
			'footer' => 'BaseFooter'
		];

		$this->getUri();
		$uri2 = explode('/', $this->uri);
		$topicId = explode('-', $uri2[3]);

		$this->setCurrentPage();
		
		$topico = new \app\models\ForumTopico();
		$this->topics_values = $topico->getTopic($topicId[0]);

		$posts = new \app\models\ForumTopicoPostagem();
		$this->posts_values = $posts->getPosts($topicId[0], $this->perPage, $this->offset);

		$amount = $posts->counter('id_topico', $this->posts_values[0]['id_topico']);
		$this->setTotalPages($amount[0]['count']);

		$this->render();		
	}

	//RECUPERA A URI DA PAGINA
	protected function getUri()
	{
		$this->uri = parse_url(filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL), PHP_URL_PATH);
	}

	//PERMITE CRIAR UMA RESPOSTA A UM TOPICO OU A UMA POSTAGEM
	public function replyPost() 
	{
		
		checkSession();
		validateSessionId();

		// Verifica se o formulário foi enviado e armazena os dados
		if ($_SERVER["REQUEST_METHOD"] == "POST") {

			if (isset($_POST['id_topico']) && isset($_POST['id_user']) && isset($_POST['reply_text'])) {
				$id_topico = filter_input(INPUT_POST, 'id_topico', FILTER_SANITIZE_STRING);
				$id_user = filter_input(INPUT_POST, 'id_user', FILTER_SANITIZE_STRING);
				$reply_text = filter_input(INPUT_POST, 'reply_text', FILTER_SANITIZE_STRING);
				$post = 'post';
			}

			if (isset($_POST['resposta']) && isset($_POST['id_postagem_referencia'])) {
				$resposta = filter_input(INPUT_POST, 'resposta', FILTER_SANITIZE_STRING);
				$id_postagem_referencia = filter_input(INPUT_POST, 'id_postagem_referencia', FILTER_SANITIZE_STRING);
				$post = 'reply';
			}

			if ($post == 'post') {

				$insert = ['id_topico'=>$id_topico, 'id_user'=>$id_user, 'texto_postagem'=>$reply_text];
				$model = new \app\models\ForumTopicoPostagem();
				$model->insert($insert);

			} else if ($post == 'reply') {

				$insert = ['id_topico'=>$id_topico, 'id_user'=>$id_user, 'texto_postagem'=>$reply_text, 'resposta'=>$resposta, 'id_postagem_referencia'=>$id_postagem_referencia];
				$model = new \app\models\ForumTopicoPostagem();
				$model->insert($insert);

			}

		}
		//Retorna para a pagina do post
		goBack();
	}

	//CRIA UM NOVO TOPICO EM UM FORUM
	public function newTopic() 
	{
		
		checkSession();
		validateSessionId();

		// Verifica se o formulário foi enviado e armazena os dados
		if ($_SERVER["REQUEST_METHOD"] == "POST") {

			if (isset($_POST['nome_topico']) && isset($_POST['texto_topico']) && isset($_POST['id_forum']) && isset($_POST['id_user'])) {
				$nome_topico = filter_input(INPUT_POST, 'nome_topico', FILTER_SANITIZE_STRING);
				$texto_topico = filter_input(INPUT_POST, 'texto_topico', FILTER_SANITIZE_STRING);
				$id_forum = filter_input(INPUT_POST, 'id_forum', FILTER_SANITIZE_STRING);
				$id_user = filter_input(INPUT_POST, 'id_user', FILTER_SANITIZE_STRING);

				$insert = ['id_forum'=>$id_forum, 'id_user'=>$id_user, 'nome_topico'=>$nome_topico, 'texto_topico'=>$texto_topico];

				$model = new \app\models\ForumTopico();
				$model->insert($insert);
				
			}

		}
		//Retorna para a pagina do post
		goBack();
	}

	//PERMITE DENUNCIAR O CONTEUDO DE UMA POSTAGEM OU DE UM TOPICO
	public function report()
	{
		checkSession();
		validateSessionId();

		// Verifica se o formulário foi enviado e armazena os dados
		if ($_SERVER["REQUEST_METHOD"] == "POST") {

			$local = filter_input(INPUT_POST, 'local', FILTER_SANITIZE_STRING);
			$tipo_secao = filter_input(INPUT_POST, 'tipo_secao', FILTER_SANITIZE_STRING);
			$id_tipo_secao = filter_input(INPUT_POST, 'id_tipo_secao', FILTER_SANITIZE_STRING);
			$id_user_denunciante = filter_input(INPUT_POST, 'id_user_denunciante', FILTER_SANITIZE_STRING);

			$insert = ['tipo_secao'=>$tipo_secao, 'id_tipo_secao'=>$id_tipo_secao, 'local'=>$local, 'id_user_denunciante'=>$id_user_denunciante];

			$model = new \app\models\LogDenuncias();
			$model->insert($insert);
				
		}
		//Retorna para a pagina do post
		goBack();
	}

}

?>