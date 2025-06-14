<?php
    class Router {
        public $routes = [];
        public $pdo;

        public function __construct(PDO $pdo) {
            $this->pdo = $pdo;
        }

        public function addRoute($uri, $route) {
            $this->routes[$uri] = $route;
        }

        public function dispatch($uri) {
            if(isset($this->routes[$uri])) {
                [$controllerName, $methodName] = explode('@', $this->routes[$uri]);

                if($controllerName === 'AuthController'){
                    require '../app/Controller/' . $controllerName . '.php';
                    $controller = new $controllerName($this->pdo);
                    $controller->$methodName();

                } elseif (isset($_SESSION['username'])) {
                    require '../app/Controller/' . $controllerName . '.php';
                    $controller = new $controllerName($this->pdo);
                    $controller->$methodName();
                }

            } else {
                echo "404 - Page non trouvée";
            }
        }
    }
?>
