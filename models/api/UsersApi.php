<?php

    require_once ROOT . '/components/Api.php';
    require_once ROOT . '/components/Db.php';

    class UsersApi extends Api
    {
        public $users_id;
        public $date;

        public function __construct()
        {
            parent::__construct();

            $this->users_id = array_shift($this->requestUri);
            if(isset($this->users_id))
                $this->isIndexRequest = true;
            $this->date = array_shift($this->requestUri);
        }

        /**
         * Метод GET
         * Вывод списка всех записей
         * http://.../users
         * @return string
         */
        public function indexAction()
        {
            echo "This is indexAction";
        }

        /**
         * Метод GET
         * Просмотр отдельной записи (по id)
         * http://.../users/1
         * @return string
         */
        public function viewAction()
        {
            if($this->date)
                $param = "users_id = {$this->users_id} AND date = '{$this->date}'";
            else
                $param = "users_id = {$this->users_id}";

            $result = $this->getUser($param);

            if(sizeof($result))
                print_r($result);
        }

        /**
         * Метод POST
         * Создание новой записи
         * http://.../users + параметры запроса ...
         * @return string
         */
        public function createAction()
        {
            $params = [];

            array_push($params, $this->users_id, $this->date, json_encode($this->requestParams), JSON_UNESCAPED_UNICODE);

            $this->createString($params);
        }

        /**
         * Метод PUT
         * Обновление данных записи
         * http://.../users + параметры запроса
         * @return string
         */
        public function updateAction()
        {
            // TODO: Проверка авторизации...
            
            echo '-----------------------------------------' . PHP_EOL;

            $db = Db::getConnection();
            $request = $db->prepare(
                'SELECT '
                .     'info '
                . 'FROM '
                .    'days_info '
                . 'WHERE users_id = :id;'
            );

            $request->bindParam(':id', $this->users_id, PDO::PARAM_INT);
            $request->execute();

            while ($row = $request->fetch()) {
                $dbdata = json_decode($row['info'], true);
            }

            echo "dbdata : " . PHP_EOL;
            print_r($dbdata);

            echo "requestParams : " . PHP_EOL;
            print_r($this->requestParams);

            foreach ($this->requestParams as $key => $value) {
                if (isset($dbdata[$key]))
                    $dbdata[$key] += 1;
                else
                    $dbdata[$key] = $value;
            }

            $request = $db->prepare(
                'UPDATE '
                .     'days_info '
                . 'SET '
                .    'info = :info '
                . 'WHERE users_id = :id AND date = :date ;'
            );

            $info = json_encode($dbdata, JSON_UNESCAPED_UNICODE);

            $request->bindParam(":info", $info, PDO::PARAM_STR);
            $request->bindParam(":id", $this->users_id, PDO::PARAM_STR);
            $request->bindParam(":date", $this->date, PDO::PARAM_STR);

            $request->execute();

            $result = $request->fetch(PDO::FETCH_ASSOC);

            echo PHP_EOL . '-----------------------------------------';
        }

        private function getUser($param)
        {
            $db = Db::getConnection();
            $request = $db->query(
                'SELECT date, info '
                . 'FROM days_info '
                . "WHERE {$param}"
            );

            $result = array();

            while($row = $request->fetch(PDO::FETCH_ASSOC))
                array_push($result, $row);

            return $result;
        }
        
        private function createString($params)
        {
            $sql = "INSERT INTO days_info VALUES(?, ?, ?)";

            $db = Db::getConnection();
            $request = $db->prepare($sql);

            $request->bindParam(1, $params[0], PDO::PARAM_INT);
            $request->bindParam(2, $params[1], PDO::PARAM_STR);
            $request->bindParam(3, $params[2], PDO::PARAM_STR);

            $request->execute();

            $result = $request->fetch(PDO::FETCH_ASSOC);
        }
    }