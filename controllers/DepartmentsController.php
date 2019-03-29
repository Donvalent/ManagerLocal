<?php

    include_once ROOT. '/models/Departments.php';
    include_once ROOT. '/models/Employees.php';

    class DepartmentsController
    {
        public function actionIndex()
        {
            $departmentsList = array();
            $departmentsList = Departments::getDepartmentsList();

            require_once(ROOT . '/view/Departments/index.php');

            return true;
        }

        public function actionAdd()
        {
            if(isset($_POST['submit']))
            {
                $title = $_POST['title'];
                if(isset($_POST['employees']))
                {
                    $employees = array();
                    $employees = $_POST['employees'];
                    Departments::addDepartment($title, $employees);
                }else{
                    Departments::addDepartment($title);
                } 
            }

            $employeesList = array();
            $employeesList = Employees::getEmployeesList();

            require_once(ROOT . '/view/Departments/add.php');

            return true;
        }
        
        public function actionView($departmentId)
        {
            $department = array();
            $department = Departments::getDepartmentById($departmentId);

            $employeesList = array();
            $employeesList = Employees::getEmployeesListByDepartment($departmentId);

            require_once(ROOT . '/view/Departments/view.php');

            return true;
        }
    }