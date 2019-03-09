<?php

    include_once ROOT. '/models/Employees.php';

    class EmployeesController
    {
        public function actionIndex()
        {
            $EmployeesList = array();
            $EmployeesList = Employees::getEmployeesList();

            require_once(ROOT . '/view/Employees/index.php');

            return true;
        }
        public function actionView($id)
        {
            $Employee = array();
            $Employee = Employees::getEmployeeById($id);

            require_once(ROOT . '/view/Employees/view.php');

            return true;
        }
    }