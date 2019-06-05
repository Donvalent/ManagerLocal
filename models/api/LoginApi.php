<?php

    require_once ROOT . '/components/Api.php';
    require_once ROOT . '/components/Db.php';

    class LoginApi extends Api
    {
        public $usersLogin;
        public $usersPassword;

        public function __construct()
        {
            parent::__construct();

            $this->usersLogin = array_shift($this->requestUri);
            $this->usersPassword = array_shift($this->requestUri);
            if(isset($this->usersLogin))
                $this->isIndexRequest = true;
        }

        /**
         * Метод GET
         * Вывод списка всех записей
         * http://.../login
         * @return string
         */
        public function indexAction()
        {
            throw new RuntimeException('Invalid method', 405);
        }

        /**
         * Метод GET
         * Просмотр отдельной записи (по login)
         * http://.../login/MyLogin
         * @return string
         */
        public function viewAction()
        {
            print_r(json_encode($this->getUser(), JSON_UNESCAPED_UNICODE));
        }

        /**
         * Метод POST
         * Создание новой записи
         * http://.../login + параметры запроса ...
         * @return string
         */
        public function createAction()
        {
            throw new RuntimeException('Invalid method', 405);
        }

        /**
         * Метод PUT
         * Обновление данных записи
         * http://.../login + параметры запроса
         * @return string
         */
        public function updateAction()
        {
            throw new RuntimeException('Invalid method', 405);
        }

        private function getUser()
        {
            $param = "WHERE login = '{$this->usersLogin}' ";
            if($this->usersPassword)
                $param = $param . "AND password = '{$this->usersPassword}'";

            $db = Db::getConnection();
            $request = $db->query(
                'SELECT login.id, fullName, gender, phone, email '
                . "FROM users "
                . "LEFT JOIN login on users.id = login.id "
                . "{$param}"
            );

            $result = array();

            while($row = $request->fetch(PDO::FETCH_ASSOC))
                array_push($result, $row);

            return $result;
        }
    }