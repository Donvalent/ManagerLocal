<?php

    include_once ROOT . '/components/Api.php'; 
    include_once ROOT . '/models/api/UsersApi.php'; 
    include_once ROOT . '/models/api/TasksApi.php';
    include_once ROOT . '/models/api/LoginApi.php';

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

                    $internalRoute = preg_replace("~$uriPattern~", $path, $uri);

                    $segment = explode('/', $internalRoute);

                    $controllerName = array_shift($segment);

                    if($controllerName == 'api')
                    {
                        try {
                            $modelApi = ucfirst(array_shift($segment)) . 'Api';
                            if (class_exists($modelApi)){
                                $api = new $modelApi();
                                echo $api->run();
                            } else
                                throw new RuntimeException('API Not Found');

                        } catch (Exception $e) {
                            echo json_encode(Array('error' => $e->getMessage()));
                        }
                        die;
                    }

                    $controllerName = ucfirst($controllerName . 'Controller');

                    $actionName = 'action'.ucfirst(array_shift($segment));

                    $parameters = $segment;

                    // Подключить файл класса-контроллера
                    $controllerFile = ROOT . '/controllers/' . $controllerName . '.php';

                    if (file_exists($controllerFile)){
                        include_once($controllerFile);
                    }

                    // Создать объект, вызвать метод (т.е. action)
                    // if (class_exists($controllerName)){
                    //     $controllerObject = new $controllerName;
                    // }
                    // else {
                    //     die;
                    // }

                    $controllerObject = new $controllerName();
                    
                    $result = call_user_func_array(array($controllerObject, $actionName), $parameters);

                    if ($result != null) {
                        break;
                    }
                }
            }
        }
    }