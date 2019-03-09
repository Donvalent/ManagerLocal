<?php

    //include_once ROOT. '/models/....php';

    class SiteController
    {
        public function actionIndex()
        {
                        

            require_once(ROOT . '/view/index.php');

            return true;
        }
    }