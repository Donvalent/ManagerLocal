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
            echo 'This is indexAction';
        }

        /**
         * Метод GET
         * Просмотр отдельной записи (по id)
         * http://.../users/1
         * @return string
         */
        public function viewAction()
        {
            echo 'This is viewAction';
        }

        /**
         * Метод POST
         * Создание новой записи
         * http://.../users + параметры запроса ...
         * @return string
         */
        public function createAction()
        {

        }

        /**
         * Метод PUT
         * Вывод списка всех записей
         * http://.../users
         * @return string
         */
        public function updateAction()
        {

        }
    }