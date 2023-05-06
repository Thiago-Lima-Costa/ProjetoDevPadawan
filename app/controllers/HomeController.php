<?php

namespace app\controllers;


class HomeController extends Controller
{

    public array $view = [
		'header' => 'BaseHeader',
		'content' => 'IndexView',
		'footer' => 'BaseFooter'
	];
    
    public array $samplePosts;
	public array $lastArticles;
	public array $team;
	public \app\support\User $user;


	public function __construct()
	{
		if(isset($_SESSION['session_id']) && isset($_SESSION['user_id'])) {
			validateSessionId();

			$this->user = new \app\support\User($_SESSION['user_id']);
		}
	}


    function index()
    {

        $this->showForuns();
		$this->showArticles();
		$this->render();
    }


    public function showForuns()
    {
		$topicos = new \app\models\ForumTopico();
		$this->samplePosts = $topicos->samplePosts();	
	}

	
    public function showArticles()
    {
		$topicos = new \app\models\Artigos();
		$this->lastArticles = $topicos->lastArticles();
	}


	public function rules()
	{
	
		$this->view = [
			'header' => 'BaseHeader',
			'content' => 'RulesView',
			'footer' => 'BaseFooter'
		];

		$this->render();

	}

	public function privacy()
	{
	
		$this->view = [
			'header' => 'BaseHeader',
			'content' => 'PrivacyView',
			'footer' => 'BaseFooter'
		];

		$this->render();

	}

	public function statistics()
	{
	
		$this->view = [
			'header' => 'BaseHeader',
			'content' => 'StatisticsView',
			'footer' => 'BaseFooter'
		];

		$this->render();

	}

	public function team()
	{
	
		$this->view = [
			'header' => 'BaseHeader',
			'content' => 'TeamView',
			'footer' => 'BaseFooter'
		];

		$equipe = new \app\models\UserPerfil();
		$this->team = $equipe->equipe();

		$this->render();

	}

}



?>