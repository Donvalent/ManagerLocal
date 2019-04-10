<?php

    include_once ROOT. '/models/Employees.php';
    include_once ROOT. '/models/Departments.php';

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
            $EmployeeList = array();
            $EmployeeList = Employees::getEmployeeById($id);

            require_once(ROOT . '/view/Employees/view.php');

            return true;
        }
        public function actionEdit($id)
        {
            $Employee = array();
            $Employee = Employees::getEmployeeById($id);

            $Departments = array();
            $Departments = Departments::getDepartmentsList();

            if(isset($_POST['submit']))
            {
                $fullname = $_POST['surname'] . ' ' . $_POST['name'] . ' ' . $_POST['lastname'];
                $gender = $_POST['gender'];
                $email = $_POST['email'];
                $phone = $_POST['phone'];
                $position = $_POST['position'];
                $salary = $_POST['salary'];
                $departments = $_POST['departments'];

                Employees::updateEmployee($id, $fullname, $gender, $email, $phone, $position, $salary, $departments);
            }

            require_once(ROOT . '/view/Employees/edit.php');
            
            return true;
        }
        public function actionAdd()
        {
            $Departments = array();
            $Departments = Departments::getDepartmentsList();

            if(isset($_POST['submit']))
            {
                $fullname = $_POST['name'] . ' ' . $_POST['surname'] . ' ' . $_POST['lastname'];
                $gender = $_POST['gender'];
                $email = $_POST['email'];
                $position = $_POST['position'];
                $salary = $_POST['salary'];
                $departments = $_POST['departments'];

                Employees::addEmployee($fullname, $gender, $email, $position, $salary, $departments);
            }

            include_once(ROOT . '/view/Employees/add.php');

            return true;
        }
    }