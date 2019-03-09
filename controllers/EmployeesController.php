<?php

    include_once ROOT. '/models/Employees.php';

    class EmployeesController
    {
        public function actionIndex()
        {
            $EmployeesList = array();
            $EmployeesList = Employees::getEmployeesList();

            require_once(ROOT . '/view/Employees.php');

            return true;
        }
    }