<?php

    //include_once ROOT. '/models/....php';

    class DepartmentsController
    {
        public function actionIndex()
        {
                        

            require_once(ROOT . '/view/Departments.php');

            return true;
        }
    }