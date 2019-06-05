<?php

    include_once ROOT. '/models/Departments.php';
    include_once ROOT. '/models/Employees.php';

    class SiteController
    {
        public function actionIndex()
        {
            $departmentsList = array();
            $departmentsList = Departments::getDepartmentsList();

            $employeesList = array();
            $employeesList = Employees::getEmployeesList();
                        

            require_once(ROOT . '/view/index.php');

            return true;
        }

        public function actionLogin()
        {

            if(isset($_POST['login']) and isset($_POST['password'])){
                $login = $_POST['login'];
                $password = $_POST['password'];

                if(Employees::isIsset($login)){
                    $person = Employees::isAuthentication($login, $password);
                    if($person['admin'] == "1")
                        $_SESSION['id'] = $person['id'];
                }

            }

            require_once(ROOT . '/view/login.php');

            return true;
        }
    }