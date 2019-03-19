<?php

    //include_once ROOT. '/models/....php';

    class TasksController
    {
        public function actionIndex()
        {
                        

            require_once(ROOT . '/view/Tasks/index.php');

            return true;
        }
    }