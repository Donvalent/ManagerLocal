<?php

include_once(ROOT . '/components/Db.php');

class Departments
{
    private static function getCountOfEmployees($departmentId)
    {
        $count = 0;
        $db = Db::getConnection();

        $result = $db->query(
            'SELECT COUNT(*) as count '
            . 'FROM department_staff '
            . 'WHERE department_staff.departments_id = \'' . $departmentId . '\';'
        );


        while ($row = $result->fetch()) {
            $count = $row['count'];
        }

        return $count;
    }
    private static function getMaxSalary($departmentId)
    {
        $salary = 0;
        $db = Db::getConnection();

        $result = $db->query(
            'SELECT MAX(salary) as maxSalary '
            . 'FROM positions '
            . 'JOIN users on users.id = positions.id '
            . 'JOIN department_staff on department_staff.workers_id = users.id '
            . 'WHERE department_staff.departments_id = \'' . $departmentId . '\';'
        );

        while ($row = $result->fetch()){
            $salary = $row['maxSalary'];
        }

        return $salary;
    }

    public static function getDepartmentsList()
    {
        $departments = array();
        $db = Db::getConnection();
        
        $result = $db->query(
            'SELECT departmens.id, departmens.title, users.fullName as leader '
            . 'FROM departmens '
            . 'JOIN users on users.id = departmens.id;'
        );

        $i = 0;

        while ($row = $result->fetch()) {
            $departments[$i]['id'] = $row['id'];
            $departments[$i]['title'] = $row['title'];
            $departments[$i]['leader'] = $row['leader'];
            $departments[$i]['countEmployees'] = static::getCountOfEmployees($row['id']);
            $departments[$i]['maxSalary'] = static::getMaxSalary($row['id']);
            $i++;
        }

        return $departments;
    }
}