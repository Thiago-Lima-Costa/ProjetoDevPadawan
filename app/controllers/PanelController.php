<?php

namespace app\controllers;
use app\support\Csrf;


class PanelController extends Controller
{
	use \app\traits\Paginate;

    public array $view = [
		'header' => 'BaseHeader',
		'content' => 'PanelView',
		'footer' => 'BaseFooter'
	];  
	public \app\support\User $user;
	private array $permissoes = [
		'Avisos' => true,
		'Escrever-Artigo' => false,
		'Editar-Artigo' => false,
		'Listar-Usuarios' => false,
		'Mensagens-de-Administradores' => false,
		'Mensagens-de-Usuarios' => false,
		'Mensagens-Externas' => false,
		'Penalidades-Aplicadas' => false,
		'Aplicar-Remover-Penalidades' => false,
		'Alterar-Nivel-de-Acesso' => false,
	];
	public array $navLinks = [];
	public string $tab;
	private string $func;
	public array $avisosDoSistema;
	public array $msgAdm;
	public array $msgUser;
	public array $listaDeUsuarios;
	public array $historicoPenalidades;
	public array $artigoEncontrado;
	
	/* 
	* NIVEL DE PERMISSOES
	* 0 - Usuario
	* 1 - Colaborador 
	* 2 - Administrador
	* 3 - Administrador/Colaborador
	* 4 - Super Administrador
	* 5 - CEO
	*/
	
	public function __construct()
	{
		if(isset($_SESSION['session_id']) && isset($_SESSION['user_id'])) {
			validateSessionId();
			$this->user = new \app\support\User($_SESSION['user_id']);
		}  else {
			$err = new \app\controllers\ErrorController();
            die();
		}

		if($this->user->nivel_privilegio == 0) {
			$err = new \app\controllers\ErrorController();
            die();
		}

		switch($this->user->nivel_privilegio) {
			case 1:
				$this->permissoes['Escrever-Artigo'] = true;
				$this->permissoes['Editar-Artigo'] = true;
				break;
			case 2:
				$this->permissoes['Mensagens-de-Administradores'] = true;
				$this->permissoes['Mensagens-de-Usuarios'] = true;
				$this->permissoes['Mensagens-Externas'] = true;
				$this->permissoes['Listar-Usuarios'] = true;
				$this->permissoes['Penalidades-Aplicadas'] = true;
				$this->permissoes['Aplicar-Remover-Penalidades'] = true;
				break;
			case 3:
				$this->permissoes['Escrever-Artigo'] = true;
				$this->permissoes['Editar-Artigo'] = true;
				$this->permissoes['Mensagens-de-Administradores'] = true;
				$this->permissoes['Mensagens-de-Usuarios'] = true;
				$this->permissoes['Mensagens-Externas'] = true;
				$this->permissoes['Listar-Usuarios'] = true;
				$this->permissoes['Penalidades-Aplicadas'] = true;
				$this->permissoes['Aplicar-Remover-Penalidades'] = true;
				break;
			case 4:
				$this->permissoes['Escrever-Artigo'] = true;
				$this->permissoes['Editar-Artigo'] = true;
				$this->permissoes['Mensagens-de-Administradores'] = true;
				$this->permissoes['Mensagens-de-Usuarios'] = true;
				$this->permissoes['Mensagens-Externas'] = true;
				$this->permissoes['Listar-Usuarios'] = true;
				$this->permissoes['Penalidades-Aplicadas'] = true;
				$this->permissoes['Aplicar-Remover-Penalidades'] = true;
				$this->permissoes['Alterar-Nivel-de-Acesso'] = true;
				break;
			case 5:
				$this->permissoes['Escrever-Artigo'] = true;
				$this->permissoes['Editar-Artigo'] = true;
				$this->permissoes['Mensagens-de-Administradores'] = true;
				$this->permissoes['Mensagens-de-Usuarios'] = true;
				$this->permissoes['Mensagens-Externas'] = true;
				$this->permissoes['Listar-Usuarios'] = true;
				$this->permissoes['Penalidades-Aplicadas'] = true;
				$this->permissoes['Aplicar-Remover-Penalidades'] = true;
				$this->permissoes['Alterar-Nivel-de-Acesso'] = true;
				break;
		}
	}

    public function index()
    {
		$this->view = [
			'header' => 'BaseHeader',
			'content' => 'PanelView',
			'footer' => 'BaseFooter'
		];

		$uri = $this->getUri();
		$uri = explode('/', $uri);

		//Baseado na uri define a aba do painel que será exibida e o metodo (se for o caso)
		if(!isset($uri[2])) {
			$this->tab = 'avisos.php';
			$this->func = 'avisos';
		} else if (isset($uri[2])) {
			$this->tab = strtolower($uri[2].'.php');
			$this->func = strtolower(str_replace('-', '_', $uri[2]));
		}

		//Chama o metodo necessario para a aba (se for o caso)
		if(method_exists($this, $this->func)){
			call_user_func([$this, $this->func]);
		}

		$this->navBar();
		$this->render();
    }

	//Baseado nas permissões do usuario retorna as opcoes que ele podera acessar
	protected function navBar()
	{
		$linkFilter = $this->getPermissoes();

		foreach($linkFilter as $link => $value) {
			if ($value === true) {
				$string = str_replace('-', ' ', $link);
				$link = strtolower($link);
				$this->navLinks[$link] = $string;
			} else if ($value === false) {
				continue;
			}
		}
	}

	//Retorna o valor do array protected $permissoes
	protected function getPermissoes()
	{
		return $this->permissoes;
	}

	//RECUPERA A URI
	protected function getUri()
	{
		$uri = parse_url(filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL), PHP_URL_PATH);

		return $uri;
	}

	//Recupera os avisos postados para os colaboradores
	public function avisos()
	{
		$this->__set('perPage', 8);
		$this->setCurrentPage();
		$model = new \app\models\AdmAvisos();
		$this->avisosDoSistema = $model->avisosDoSistema($this->perPage, $this->offset);
		$amount = $model->counter(1, 1);
		$this->setTotalPages($amount[0]['count']);
	}

	//Cria um novo para os colaboradores
	public function enviarAviso()
	{
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			if (!empty($_POST['aviso']) && !empty($_POST['tipo']) && !empty($_POST['nome_adm'])) {
				$aviso = filter_input(INPUT_POST, 'aviso', FILTER_SANITIZE_STRING);
				$tipo = filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_STRING);
				$nome_adm = filter_input(INPUT_POST, 'nome_adm', FILTER_SANITIZE_STRING);
				$insert = ['aviso'=>$aviso, 'tipo'=>$tipo, 'autor'=>$nome_adm];
				$model = new \app\models\AdmAvisos();
				$model->insert($insert);
			}
		}
		goBack();
	}

	//Aplica ou remove uma punição
	public function aplicar_remover_penalidades()
	{
		if(!isset($_GET['user'])) {	
			$this->listaDeUsuarios = [];
		} else if (isset($_GET['user'])) {
			$user = filter_input(INPUT_GET, 'user', FILTER_SANITIZE_STRING);
			$model = new \app\models\UserPerfil();
			$this->listaDeUsuarios = $model->historicoUsuario($user);

			$model2 = new \app\models\AdmHistoricoPenalidades();
			$this->historicoPenalidades = $model2->historicoDoUsuario($user);
		}
	}

	//Altera os privilégios de um colaborador
	public function alterar_nivel_de_acesso()
	{
		if(!isset($_GET['user'])) {	
			$this->listaDeUsuarios = [];
		} else if (isset($_GET['user'])) {
			$user = filter_input(INPUT_GET, 'user', FILTER_SANITIZE_STRING);
			$model = new \app\models\UserPerfil();
			$this->listaDeUsuarios = $model->historicoUsuario($user);

			$model2 = new \app\models\AdmHistoricoPenalidades();
			$this->historicoPenalidades = $model2->historicoDoUsuario($user);
		}
	}


	//Escreve e persiste no BD um artigo do blog
	public function enviarArtigo()
	{
		Csrf::validateToken();

		if ($_SERVER["REQUEST_METHOD"] == "POST") {

			if (!empty($_POST['titulo_artigo']) && !empty($_POST['subtitulo_artigo']) && !empty($_POST['introducao_artigo']) && !empty($_POST['desenvolvimento_artigo']) && !empty($_POST['conclusao_artigo']) && !empty($_POST['id_user'])) {

				
				$titulo_artigo = filter_input(INPUT_POST, 'titulo_artigo', FILTER_SANITIZE_STRING);
				$subtitulo_artigo = filter_input(INPUT_POST, 'subtitulo_artigo', FILTER_SANITIZE_STRING);
				$introducao_artigo = filter_input(INPUT_POST, 'introducao_artigo', FILTER_SANITIZE_STRING);
				$desenvolvimento_artigo = filter_input(INPUT_POST, 'desenvolvimento_artigo', FILTER_SANITIZE_STRING);
				$conclusao_artigo = filter_input(INPUT_POST, 'conclusao_artigo', FILTER_SANITIZE_STRING);
				$id_autor = filter_input(INPUT_POST, 'id_user', FILTER_SANITIZE_STRING);

				if(!empty($_POST['categoria'])){
					$categoria = $_POST['categoria'];
					$categoria = implode(' ', $categoria);
					$categoria = filter_var($categoria);
				} else {
					$categoria = '#Geral';
				}

				if(!empty($_FILES['imagem_principal']['tmp_name'])){
					$name1 = 'articleImg_'.trim(str_replace('-', ' ', $titulo_artigo)).'principal'.date("FjYgia");
					$img_artigo = \app\support\EditImage::uploadImage($_FILES['imagem_principal'], 800, 1200, $name1, 'article_img');
				} else {
					$img_artigo = '';
				}
				
				if(!empty($_FILES['imagem_miniatura']['tmp_name'])){
					$name2 = 'articleImg_'.trim(str_replace('-', ' ', $titulo_artigo)).'miniatura'.date("FjYgia");
					$img_artigo_miniatura = \app\support\EditImage::uploadImage($_FILES['imagem_miniatura'], 300, 300, $name2, 'article_img');
				} else {
					$img_artigo_miniatura = 'Assets/img/article_img/demoimg.jpg';
				}

				if(!empty($_FILES['imagem_desenvolvimento']['tmp_name'])){
					$name3 = 'articleImg_'.trim(str_replace('-', ' ', $titulo_artigo)).'desenvolvimento'.date("FjYgia");
					$img_desenvolvimento = \app\support\EditImage::uploadImage($_FILES['imagem_desenvolvimento'], 800, 1200, $name3, 'article_img');
				} else {
					$img_desenvolvimento = '';
				}

				if(!empty($_FILES['imagem_conclusao']['tmp_name'])){
					$name4 = 'articleImg_'.trim(str_replace('-', ' ', $titulo_artigo)).'conclusao'.date("FjYgia");
					$img_conclusao = \app\support\EditImage::uploadImage($_FILES['imagem_conclusao'], 800, 1200, $name4, 'article_img');
				} else {
					$img_conclusao = '';
				}

				$insert = ['categoria'=>$categoria, 'titulo_artigo'=>$titulo_artigo, 'subtitulo_artigo'=>$subtitulo_artigo,'introducao_artigo'=>$introducao_artigo, 'desenvolvimento_artigo'=>$desenvolvimento_artigo, 'conclusao_artigo'=>$conclusao_artigo, 'id_autor'=>$id_autor, 'img_artigo'=>$img_artigo, 'img_artigo_miniatura'=>$img_artigo_miniatura, 'img_desenvolvimento'=>$img_desenvolvimento, 'img_conclusao'=>$img_conclusao];

				$model = new \app\models\Artigos();
				$model->insert($insert);	
			}
		}
		goBack();
	}

	//Retorna os artigos escritos pelo colaborador e permite edita-los
	public function editar_artigo()
	{
		if(!isset($_GET['article'])) {
			if($this->user->nivel_privilegio < 4) {

				$this->__set('perPage', 20);
				$this->setCurrentPage();
				$model = new \app\models\Artigos();
				$this->artigoEncontrado = $model->listaPaginada($this->user->user_id, $this->perPage, $this->offset);
				$amount = $model->counter(1, 1);
				$this->setTotalPages($amount[0]['count']);

			} else if ($this->user->nivel_privilegio >= 4) {

				$this->__set('perPage', 20);
				$this->setCurrentPage();
				$model = new \app\models\Artigos();
				$this->artigoEncontrado = $model->listaPaginada('1 OR a.id_autor > 1', $this->perPage, $this->offset);
				$amount = $model->counter(1, 1);
				$this->setTotalPages($amount[0]['count']);

			}
		} else if (isset($_GET['article'])) {
			$article = filter_input(INPUT_GET, 'article', FILTER_SANITIZE_STRING);
			$collaborator = filter_input(INPUT_GET, 'collaborator', FILTER_SANITIZE_STRING);
			$model = new \app\models\Artigos();
			$this->artigoEncontrado = $model->recuperaArtigo($collaborator, $article);
		}
	}

	//Persiste as alteracoes em um artigo
	public function editArticle()
	{
		Csrf::validateToken();
		
		if ($_SERVER["REQUEST_METHOD"] == "POST") {

			if (!empty($_POST['titulo_artigo']) && !empty($_POST['subtitulo_artigo']) && !empty($_POST['introducao_artigo']) && !empty($_POST['desenvolvimento_artigo']) && !empty($_POST['conclusao_artigo']) && !empty($_POST['id_user'])) {

				
				$titulo_artigo = filter_input(INPUT_POST, 'titulo_artigo', FILTER_SANITIZE_STRING);
				$subtitulo_artigo = filter_input(INPUT_POST, 'subtitulo_artigo', FILTER_SANITIZE_STRING);
				$introducao_artigo = filter_input(INPUT_POST, 'introducao_artigo', FILTER_SANITIZE_STRING);
				$desenvolvimento_artigo = filter_input(INPUT_POST, 'desenvolvimento_artigo', FILTER_SANITIZE_STRING);
				$conclusao_artigo = filter_input(INPUT_POST, 'conclusao_artigo', FILTER_SANITIZE_STRING);
				$id_artigo = filter_input(INPUT_POST, 'id_artigo', FILTER_SANITIZE_STRING);

				if(!empty($_POST['categoria'])){
					$categoria = $_POST['categoria'];
					$categoria = implode(' ', $categoria);
					$categoria = filter_var($categoria);
				} else {
					$categoria = '#Geral';
				}

				$update = ['categoria'=>$categoria, 'titulo_artigo'=>$titulo_artigo, 'subtitulo_artigo'=>$subtitulo_artigo,'introducao_artigo'=>$introducao_artigo, 'desenvolvimento_artigo'=>$desenvolvimento_artigo, 'conclusao_artigo'=>$conclusao_artigo];
				
				$model = new \app\models\Artigos();
				$model->updateMultiples($update, 'id_artigo', $id_artigo);	
			}
		}
		goBack();	
	}

	//Chat de adm
	public function mensagens_de_administradores()
	{
		$this->__set('perPage', 15);
		$this->setCurrentPage();
		$model = new \app\models\AdmMsgAdm();
		$this->msgAdm = $model->chatAdm($this->perPage, $this->offset);
		$amount = $model->counter(1, 1);
		$this->setTotalPages($amount[0]['count']);
	}

	//Cria um novo para os colaboradores
	public function enviarMensagem()
	{
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			if (!empty($_POST['mensagem']) && !empty($_POST['id_adm']) && !empty($_POST['nome_adm'])) {
				$mensagem = filter_input(INPUT_POST, 'mensagem', FILTER_SANITIZE_STRING);
				$id_adm = filter_input(INPUT_POST, 'id_adm', FILTER_SANITIZE_STRING);
				$nome_adm = filter_input(INPUT_POST, 'nome_adm', FILTER_SANITIZE_STRING);
			}

			if (isset($_POST['resposta']) && isset($_POST['id_referencia'])) {
				$resposta = 1;
				$id_referencia = filter_input(INPUT_POST, 'id_referencia', FILTER_SANITIZE_STRING);
			} else {
				$resposta = 0;
				$id_referencia = null;
			}

			$model = new \app\models\AdmMsgAdm();
			$model->enviarMensagem($mensagem, $id_adm, $nome_adm, $resposta, $id_referencia);
		}
		goBack();
	}

	//Exibe as mensagens enviadas por usuarios pelo campo de denuncia ou de fale conosco
	public function mensagens_de_usuarios()
	{
		$this->__set('perPage', 15);
		$this->setCurrentPage();
		$model = new \app\models\LogDenuncias();
		$this->msgUser = $model->log($this->perPage, $this->offset);
		$amount = $model->counter(1, 1);
		$this->setTotalPages($amount[0]['count']);
	}

	//Exibe as mensagens enviadas por usuarios pelo campo de denuncia ou de fale conosco
	public function mensagens_externas()
	{
		$this->__set('perPage', 15);
		$this->setCurrentPage();
		$model = new \app\models\AdmContato();
		$this->msgUser = $model->mostrarMensagens($this->perPage, $this->offset);
		$amount = $model->counter(1, 1);
		$this->setTotalPages($amount[0]['count']);

	}

	//Lista todos os usuarios do forum
	public function listar_usuarios()
	{
		if(!isset($_GET['user'])) {
			$this->__set('perPage', 30);
			$this->setCurrentPage();
			$model = new \app\models\UserPerfil();
			$this->listaDeUsuarios = $model->listaPaginada($this->perPage, $this->offset);
			$amount = $model->counter(1, 1);
			$this->setTotalPages($amount[0]['count']);
		} else if (isset($_GET['user'])) {
			$user = filter_input(INPUT_GET, 'user', FILTER_SANITIZE_STRING);
			$model = new \app\models\UserPerfil();
			$this->listaDeUsuarios = $model->buscaUsuario($user);
		}
	}

	//Exibe o historico de punicoes
	public function penalidades_aplicadas()
	{
		if(!isset($_GET['user'])) {
			$this->__set('perPage', 30);
			$this->setCurrentPage();
			$model = new \app\models\AdmHistoricoPenalidades();
			$this->historicoPenalidades = $model->historico($this->perPage, $this->offset);
			$amount = $model->counter(1, 1);
			$this->setTotalPages($amount[0]['count']);
		} else if (isset($_GET['user'])) {
			$user = filter_input(INPUT_GET, 'user', FILTER_SANITIZE_STRING);
			$model = new \app\models\AdmHistoricoPenalidades();
			$this->historicoPenalidades = $model->historicoDoUsuario($user);
		}
	}

	protected function uploadImage($file, $name, $sizeX, $sizeY)
	{
		$fileName = $file['name'];
        $fileType = $file['type'];
        $fileSize = $file['size'];
        $fileTmpName = $file['tmp_name'];
        $fileError = $file['error'];

        if ($fileError !== UPLOAD_ERR_OK || $fileTmpName == '') {
            return false;
        }

		//Verifica a extensao e limita o tipo da imagem à jpeg, jpg e png
		$extension = pathinfo($fileName, PATHINFO_EXTENSION); 
		if ($extension != 'jpeg' && $extension != 'jpg' && $extension != 'png') {
			return false;
		}

		// Define o novo nome do arquivo e a pasta de destino
		$newName = 'article_img_'.uniqid().'.'.$extension;
		$destination = __DIR__.'/../../public/Assets/img/article_img/'.$newName;

		//Salva a nova imagem do usuario 
		move_uploaded_file($fileTmpName, $destination);
		//Chama a funcao resizeImage
		//$image_path = 'Assets/img/'.$dir.'/'.$newName;
		resizeImage($destination, $sizeX, $sizeY);

		//Retorna um nome da imagem para ser salvo no BD
		$imagePathForDB = 'Assets/img/article_img/'.$newName;
		return $imagePathForDB;
	}

}

?>