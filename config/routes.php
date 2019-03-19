<?php
    return array(
        // Employees
        'employees/view/([0-9]+)' => 'employees/view/$1',
        'employees/edit/([0-9]+)' => 'employees/edit/$1',
        'employees/add' => 'employees/add',
        'employees' => 'employees/index',

        // Tasks
        'tasks' => 'tasks/index',

        // Departments
        'departments' => 'departments/index',

        '' => 'site/index',
    );