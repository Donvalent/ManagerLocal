<?php

    abstract class Api
    {
        public $apiName = '';

        protected $method = '';

        public $requestUri = [];
        // JSON
        public $requestParams = '';

        protected $action = '';

        protected $isIndexRequest = false;

        public function __construct()
        {
            header("Access-Control-Allow-Orgin: *");
            header("Access-Control-Allow-Methods: *");
            header("Content-Type: application/json");

            $this->method = $_SERVER['REQUEST_METHOD'];
            // Writing uri in array
            $this->requestUri = array_slice(explode('/', trim($_SERVER['REQUEST_URI'],'/')), 1);
            $this->requestParams = $this->getRequestParams($this->method);

            $this->apiName = ucfirst(array_shift($this->requestUri));
        }

        public function run()
        {
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
                    return ($this->isIndexRequest == true) ? 'viewAction' : 'indexAction';
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
            // GET данные возвращаем как есть
            if ($method === 'GET') return $_GET;
        
            // POST, PUT, PATCH или DELETE
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