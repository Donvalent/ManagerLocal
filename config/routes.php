<?php

    $apiroute = 'api/error';

    if ($_SERVER['REQUEST_METHOD'] == 'GET')
        $apiroute = 'api/get';
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
        $apiroute = 'api/post';
    if ($_SERVER['REQUEST_METHOD'] == 'PUT')
        $apiroute = 'api/put';
    if ($_SERVER['REQUEST_METHOD'] == 'PATCH')
        $apiroute = 'api/patch';

    return array(
        // Employees
        'employees/view/([0-9]+)' => 'employees/view/$1',
        'employees/edit/([0-9]+)' => 'employees/edit/$1',
        'employees/add' => 'employees/add',
        'employees' => 'employees/index',

        // Tasks
        'tasks' => 'tasks/index',

        // Departments
        'departments/view/([0-9]+)' => 'departments/view/$1',
        'departments/add' => 'departments/add',
        'departments' => 'departments/index',

        // API
        'api' => '' . $apiroute . '',

        '' => 'site/index',
    );