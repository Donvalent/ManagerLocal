<?php

    class Router
    {
        private $routes;

        public function __construct()
        {
            $routesPath = ROOT.'/config/routes.php';
            $this->routes = include($routesPath);
        }

        private function getURI()
        {
            if (!empty($_SERVER['REQUEST_URI'])){
                $uri = trim($_SERVER['REQUEST_URI'], '/');
            }
            return $uri;
        }

        public function run()
        {
            // Получить строку запроса
            $uri = $this->getURI();
           
            // Проверить наличие такого запроса в routes.php
            foreach ($this->routes as $uriPattern => $path) {
                if(preg_match("~$uriPattern~", $uri)){
                    $segment = explode('/', $path);
                    $controllerName = array_shift($segment).'Controller';
                    $controllerName = ucfirst($controllerName);

                    $actionName = 'action'.ucfirst(array_shift($segment));

                    // Подключить файл класса-контроллера
                    $controllerFile = ROOT . '/controllers/' . $controllerName . '.php';

                    if (file_exists($controllerFile)){
                        include_once($controllerFile);
                    }

                    // Создать объект, вызвать метод (т.е. action)
                    $controllerObject = new $controllerName;
                    $result = $controllerObject->$actionName();
                    if ($result != null) {
                        break;
                    }
                }
            }
        }
    }