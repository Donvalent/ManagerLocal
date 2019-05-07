<?php

    abstract class Api
    {
        public $apiName = '';

        protected $method = '';

        public $requestUri = [];
        public $requestParams = [];

        protected $action = '';

        public function __construct()
        {
            header("Access-Control-Allow-Orgin: *");
            header("Access-Control-Allow-Methods: *");
            header("Content-Type: application/json");

            $this->method = $_SERVER['REQUEST_METHOD'];
            // Writing uri in array
            $this->requestUri = explode('/', trim($_SERVER['REQUEST_URI'],'/'));
            // Delete the string 'api' in first item of the array
            $this->requestUri = array_slice($this->requestUri, 1);

            $this->requestParams = $this->getRequestParams($this->method);
        }

        public function run()
        {
            if (!$this->requestUri and ucfirst(array_shift($this->requestUri)) !== $this->apiName) {
                throw new RuntimeException('API Not Found', 404);
            }

            $this->action = $this->getAction();

            if (method_exists($this, $this->action)) {
                return $this->{$this->action}();
            } else {
                throw new RuntimeException('Invalid method', 405);
            }
        }

        protected function response($data, $status = 500)
        {
            header("HTTP/1.1 " . $status . " " . $this->requestStatus($status));
            return json_encode($data);
        }

        protected function getAction()
        {
            switch ($this->method) {
                case 'GET':
                    return (isset($this->requestUri[1]) ? 'viewAction' : 'indexAction');
                    break;
                case 'POST':
                    return 'createAction';
                    break;
                case 'PUT':
                    return 'updateAction';
                    break;
                case 'PATCH':
                    return 'updateAction';
                    break;
                default:
                    return null;
            }
        }

        private function getRequestParams($method)
        {
            // GET или POST: данные возвращаем как есть
            if ($method === 'POST') return $_POST;
            if ($method === 'GET') return $_GET;
        
            // PUT, PATCH или DELETE
            $data = array();
            $exploded = explode('&', file_get_contents('php://input'));
        
            foreach($exploded as $pair) {
                $item = explode('=', $pair);
                if (count($item) == 2) {
                    $data[urldecode($item[0])] = urldecode($item[1]);
                }
            }
        
            return $data;
        }

        private function requestStatus($code)
        {
            $status = array(
                200 => 'OK',
                404 => 'Not Found',
                405 => 'Method Not Allowed',
                500 => 'Internal Server Error',
            );
            return ($status[$code])?$status[$code]:$status[500];
        }

        abstract protected function indexAction();
        abstract protected function viewAction();
        abstract protected function createAction();
        abstract protected function updateAction();

    }