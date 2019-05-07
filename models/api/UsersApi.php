<?php

    require_once ROOT . '/components/Api.php';
    require_once ROOT . '/components/Db.php';

    class UsersApi extends Api
    {
        public $apiName = 'Users';

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
            // Delete users in uri
            array_shift($this->requestUri);

            $usersId = array_shift($this->requestUri);
            $date = array_shift($this->requestUri);

            if($date)
                $param = "users_id = {$usersId} AND date = \"{$date}\"";
            else
                $param = "users_id = {$usersId}";

            $result = $this->getUser($param);

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
            // Delete users in uri
            array_shift($this->requestUri);

            $usersId = array_shift($this->requestUri);
            $date = array_shift($this->requestUri);
            $params = [];

            array_push($params, $usersId, $date, json_encode($this->requestParams), JSON_UNESCAPED_UNICODE);

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
            $request = $db->query(
                'SELECT '
                .     'info '
                . 'FROM '
                .    'days_info '
                . 'WHERE users_id = 2;'
            );

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
                .    'info = ? '
                . 'WHERE users_id = 2 AND date = ? ;'
            );

            $info = json_encode($dbdata, JSON_UNESCAPED_UNICODE);
            $date = date("Y-m-d");

            $request->bindParam(1, $info, PDO::PARAM_STR);
            $request->bindParam(2, $date, PDO::PARAM_STR);

            $request->execute();

            $result = $request->fetch(PDO::FETCH_ASSOC);

            echo PHP_EOL . '-----------------------------------------';
        }

        private function getUser($param)
        {
            $db = Db::getConnection();
            $request = $db->query(
                "SELECT date, info "
                . "FROM days_info "
                . "WHERE {$param}"
            );

            while($row = $request->fetch(PDO::FETCH_ASSOC))
                return $row;
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