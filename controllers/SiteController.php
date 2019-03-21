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
    }