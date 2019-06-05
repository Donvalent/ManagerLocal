<?php
    return array(
        // Employees
        'employees/view/([0-9]+)' => 'employees/view/$1',
        'employees/edit/([0-9]+)' => 'employees/edit/$1',
        'employees/add' => 'employees/add',
        'employees' => 'employees/index',

        // Tasks
        'tasks/view/([0-9]+)' => 'tasks/view/$1',
        'tasks/edit/([0-9]+)' => 'tasks/edit/$1',
        'tasks/add' => 'tasks/add',
        'tasks' => 'tasks/index',

        // Departments
        'departments/view/([0-9]+)' => 'departments/view/$1',
        'departments/add' => 'departments/add',
        'departments' => 'departments/index',

        // API
        'api/users' => 'api/users',
        'api/tasks' => 'api/tasks',
        'api/login' => 'api/login',
        'api' => 'api',

        '' => 'site/index',
        'login' => 'site/login'
    );