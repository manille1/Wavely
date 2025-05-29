<?php
    class Router {
        public $routes = [];

        public function addRoute($uri, $route) {
            $this->routes[$uri] = $route;
        }

        public function dispatch($uri) {
            if(isset($this->routes[$uri])) {
                [$controllerName, $methodName] = explode('@', $this->routes[$uri]);

                require '../app/Controller/' . $controllerName . '.php';

                $controller = new $controllerName();
                $controller->$methodName();

            } else {
                echo "404 - Page non trouvée";
            }
        }
    }
?>