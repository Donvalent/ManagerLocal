<?php
    return array(
        'employees/([0-9]+)' => 'employees/view/$1',
        'employees' => 'employees/index',   // actionIndex в EmployeesController
        'tasks' => 'tasks/index',
        'departments' => 'departments/index',

        '' => 'site/index',   // actionIndex в ReportsController
    );