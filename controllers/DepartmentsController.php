<?php

    include_once ROOT. '/models/Departments.php';

    class DepartmentsController
    {
        public function actionIndex()
        {
             $departmentsList = array();
             $departmentsList = Departments::getDepartmentsList();

            require_once(ROOT . '/view/Departments/index.php');

            return true;
        }
    }