<?php

    require_once ROOT . '/components/Api.php';
    require_once ROOT . '/components/Db.php';

    class TasksApi extends Api
    {
        public $users_id;
        public $tasks_id;

        public function __construct()
        {
            parent::__construct();

            $this->users_id = array_shift($this->requestUri);
            if(isset($this->users_id))
                $this->isIndexRequest = true;
            $this->tasks_id = array_shift($this->requestUri);
        }

        /**
         * Метод GET
         * Вывод списка всех заданий
         * http://.../tasks
         * @return string
         */
        public function indexAction()
        {
            echo "This is indexAction";
        }

        /**
         * Метод GET
         * Просмотр отдельной записи (по id)
         * http://.../tasks/1
         * @return string
         */
        public function viewAction()
        {
            print_r(json_encode($this->getTasks(), JSON_UNESCAPED_UNICODE));
        }

        /**
         * Метод POST
         * Создание новой записи
         * http://.../tasks + параметры запроса ...
         * @return string
         */
        public function createAction()
        {
            
        }

        /**
         * Метод PUT
         * Обновление данных записи
         * http://.../tasks + параметры запроса
         * @return string
         */
        public function updateAction()
        {
            
        }

        private function getTasks()
        {
            $param = "WHERE worker = {$this->users_id}";
            if($this->tasks_id)
                $param = $param . " AND id = {$this->tasks_id}";

            $db = Db::getConnection();
            $request = $db->query(
                'SELECT id, title, description, status, date, deadline '
                . 'FROM tasks '
                . "{$param}"
            );

            $result = array();

            while($row = $request->fetch(PDO::FETCH_ASSOC))
                array_push($result, $row);

            return $result;
        }
    }