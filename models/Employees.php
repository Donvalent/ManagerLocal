<?php

include_once(ROOT . '/components/Db.php');

class Employees
{
    public static function getEmployeesList()
    {
        $employeesList = array();
        $db = Db::getConnection();

        $result = $db->query(
            'SELECT users.id, users.fullName, users.phone, users.email, positions.title as position, positions.salary, departmens.title as deportmen '
            . 'FROM users '
            . 'JOIN positions on positions.id = users.id '
            . 'JOIN department_staff on department_staff.workers_id = users.id '
            . 'JOIN departmens on departmens.id = department_staff.departments_id'
            );

        $i = 0;
        while($row = $result->fetch()){
            $employeesList[$i]['id'] = $row['id'];
            $employeesList[$i]['fullName'] = $row['fullName'];
            $employeesList[$i]['phone'] = $row['phone'];
            $employeesList[$i]['email'] = $row['email'];
            $employeesList[$i]['position'] = $row['position'];
            $employeesList[$i]['salary'] = $row['salary'];
            $employeesList[$i]['deportmen'] = $row['deportmen'];
            $i++;
        }

        return $employeesList;
    }
}