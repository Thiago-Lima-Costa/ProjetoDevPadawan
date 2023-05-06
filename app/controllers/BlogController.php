<?php

namespace app\controllers;


class BlogController extends Controller
{

	use \app\traits\Paginate;

    public array $view = [
		'header' => 'BaseHeader',
		'content' => 'BlogView',
		'footer' => 'BaseFooter'
	];  
	public \app\support\User $user;
	protected string $uri;
	public array $blog;
	public array $artigo;

	//EXIBE TODOS OS ATIGOS DISPONIVEIS
    public function index()
    {
		$this->view = [
			'header' => 'BaseHeader',
			'content' => 'BlogView',
			'footer' => 'BaseFooter'
		];

		if(isset($_SESSION['session_id']) && isset($_SESSION['user_id'])) {
			validateSessionId();
			$this->user = new \app\support\User($_SESSION['user_id']);
		}

		$this->setCurrentPage();

		$artigos = new \app\models\Artigos();
		$this->blog = $artigos->blog($this->perPage, $this->offset);

		$amount = $artigos->counter(1, 1);
		$this->setTotalPages($amount[0]['count']);

		$this->render();
    }

	//EXIBE UM ARTIGO
	public function article()
    {
		try {

			if(isset($_SESSION['session_id']) && isset($_SESSION['user_id'])) {
				validateSessionId();
				$this->user = new \app\support\User($_SESSION['user_id']);
			}

			$this->view = [
				'header' => 'BaseHeader',
				'content' => 'ArticleView',
				'footer' => 'BaseFooter'
			];

			$this->getUri();
			$uri2 = explode('/', $this->uri);
			$articleId = explode('-', $uri2[2]);

			$artigos = new \app\models\Artigos();
			$this->artigo = $artigos->article($articleId[0]);
			$artigos->addAccess($articleId[0]);

			$this->render();

		} catch (Exception $e) {
			$err = new \app\controllers\ErrorController($e);
		}	
	}

	//RECUPERA A URI
	protected function getUri()
	{
		$this->uri = parse_url(filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL), PHP_URL_PATH);
	}

	//PERMITE DENUNCIAR UM ARTIGO
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