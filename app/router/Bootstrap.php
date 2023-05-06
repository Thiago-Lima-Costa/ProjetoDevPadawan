<?php

namespace app\router;

use app\controllers\ErrorController;


class Bootstrap
{

    //RECUPERA O METODO DA REQUISICAO
    protected static function requestMethod():string
    {
		return $_SERVER['REQUEST_METHOD'];
	}
	
	//RECUPERA A URI
    protected static function getUri():string
    {
		return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
	}

    //RECUPERA O ARRAY DE ROTAS VINDO DA CLASSE ROUTER
    protected static function getRoutes():array
    {
		return Router::routes();
	}


    //ATRAVES DOS METODOS GETURI() E GETROUTES() INSTANCIA O CONTROLADOR E EXECUTA O METODO
    public static function execute()
    {

		try {

			$requestMethod = self::requestMethod();
			$uri = self::getUri();
			$routes = self::getRoutes();

			//Corrigir esse erro!
			//ErrorController::handleErrors();

			foreach ($routes[$requestMethod] as $route => $controller) { 
				
				if($route == $uri) {
					
					// Recupera o nome do controller e o metodo
					$classPath = '\\app\\controllers\\'.$controller[0];
					$methodName = $controller[1];
				
					//Verifica se a classe do controller existe e caso exista instancia o controller
					if(!class_exists($classPath)){		
						$err = new \app\controllers\ErrorController();
					}
					
					$class = new $classPath;
					
					//Verifica se dentro do controller existe o metodo e caso exista faz a chamada do metodo
					if (!method_exists($class, $methodName)) {	
						$err = new \app\controllers\ErrorController();
					}

					$class->$methodName();

					break;

				} else if (preg_match('#^'.$route.'$#i', $uri, $matches)) {
					
					// Recupera o nome do controller e o metodo
					$classPath = '\\app\\controllers\\'.$controller[0];
					$methodName = $controller[1];
				
					//Verifica se a classe do controller existe e caso exista instancia o controller
					if(!class_exists($classPath)){		
						$err = new \app\controllers\ErrorController();
					}
					
					$class = new $classPath;
					
					//Verifica se dentro do controller existe o metodo e caso exista faz a chamada do metodo
					if (!method_exists($class, $methodName)) {	
						$err = new \app\controllers\ErrorController();
					}

					$class->$methodName();

					break;

				}
			}

		} catch (Exception $e) {

			$err = new \app\controllers\ErrorController($e);

		}
	}

}

?>