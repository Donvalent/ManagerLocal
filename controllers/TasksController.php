<?php

    include_once ROOT. '/models/Tasks.php';

    class TasksController
    {
        public function actionIndex()
        {
            $taskList = Tasks::getTasks();

            require_once(ROOT . '/view/Tasks/index.php');

            return true;
        }

        public function actionView($id)
        {
            $task = Tasks::getTaskById($id);

            require_once(ROOT . '/view/Tasks/view.php');

            return true;
        }

        public function actionEdit($id)
        {
            $task = Tasks::getTaskById($id);
            $employeesList = Employees::getEmployeesList();

            if(isset($_POST['submit']))
            {
                $title = $_POST['title'];
                $status = Tasks::getStatus($_POST['status'])['id'];
                $worker = $_POST['worker'];
                $description = $_POST['description'];
                $date = $_POST['date'];
                $deadline = $_POST['deadline'];

                Tasks::updateTask($id, $title, $description, $worker, $status, $date, $deadline);
            }

            require_once(ROOT . '/view/Tasks/edit.php');

            return true;
        }

        public function actionAdd()
        {
            $employeesList = Employees::getEmployeesList();

            if(isset($_POST['submit']))
            {
                $title = $_POST['title'];
                $status = Tasks::getStatus($_POST['status'])['id'];
                $worker = $_POST['worker'];
                $description = $_POST['description'];
                $date = $_POST['date'];
                $deadline = $_POST['deadline'];

                Tasks::addTask($title, $description, $worker, $status, $date, $deadline);
            }

            require_once(ROOT . '/view/Tasks/add.php');

            return true;
        }
    }