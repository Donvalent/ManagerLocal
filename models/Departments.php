<?php

include_once(ROOT . '/components/Db.php');

class Departments
{
    // *********************
    //    Private function
    // *********************

    /**
     * Getting the count of employees
     * 
     * @param int $departmentId Departments id
     * 
     * @return int Count of employees
     */
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

    /**
     * Getting maximum salary of departments employees
     * 
     * @param int $departmentId Departments id
     * 
     * @return float Max salary
     */
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

    /**
     * Adding new department
     * 
     * @param string @title Title of new department
     * 
     * @return int Id of new department
     */
    private static function newDepartment($title)
    {
        $db = Db::getConnection();

        // Adding new department
        $sql =
        'INSERT INTO '
        . 'departments '
            . '(id, title) '
        . 'VALUES '
            . '(NULL, \'' . $title . '\')';

        $stmt = $db->prepare($sql);
        $stmt->execute();

        // Getting new departments id
        $sql = 
        'SELECT departments.id '
        . 'FROM departments '
        . 'WHERE departments.title = \'' . $title . '\' ';

        $stmt = $db->prepare($sql);
        $stmt->execute();
        while ($row = $stmt->fetch()) {
            return $row['id'];
        }
    }

    /**
     * Filling the department with employees
     * 
     * @param int $departmentId Departments id
     * @param array $employees Array fullnames of employees
     */
    private static function fillDepartment($departmentId, $employees)
    {
        $db = Db::getConnection();
        foreach ($employees as $employee => $value) {
            // Получение id работника по ФИО
            $sql = 'SELECT users.id '
            . 'FROM users '
            . 'WHERE users.fullName = \''. $value .'\';';

            $stmt = $db->prepare($sql);
            $stmt->execute();
            while ($row = $stmt->fetch())
            {
                // Заполнение отдела по id работниками по id
                $sql =
                'INSERT INTO department_staff (department_staff.departments_id, department_staff.workers_id) '
                . 'VALUES ('.  $departmentId .', '. $row['id'] .');';
                $stmt = $db->prepare($sql);
                $stmt->execute();
            }
        }          
    }

    // *********************
    //    Public function
    // *********************

    /**
     * Getting departments list
     * 
     * @return array Associative array containing
     *              'id', 'title', 'countEmployees', 'maxSalary'
     */
    public static function getDepartmentsList()
    {
        $departments = array();
        $db = Db::getConnection();

        // Getting departments id and title
        $result = $db->query(
            'SELECT departments.id, departments.title '
            . 'FROM departments'
        );

        $i = 0;

        while ($row = $result->fetch()) {
            $departments[$i]['id'] = $row['id'];
            $departments[$i]['title'] = $row['title'];
            $departments[$i]['countEmployees'] = static::getCountOfEmployees($row['id']);
            $departments[$i]['maxSalary'] = static::getMaxSalary($row['id']);
            $i++;
        }

        return $departments;
    }

    /**
     * Getting department by id
     * 
     * @param int $departmentId Departments id
     * 
     * @return array Associative array containing
     *              'id', 'title', 'countEmployees', 'maxSalary'
     */
    public static function getDepartmentById($departmentId)
    {
        $department = array();

        $db = Db::getConnection();
        
        // Getting departments id and title
        $result = $db->query(
            'SELECT departments.id, departments.title '
            . 'FROM departments '
            . 'WHERE departments.id = '. $departmentId .';'
        );

        while ($row = $result->fetch()) {
            $department['id'] = $row['id'];
            $department['title'] = $row['title'];
            $department['countEmployees'] = static::getCountOfEmployees($row['id']);
            $department['maxSalary'] = static::getMaxSalary($row['id']);
        }

        return $department;
    }

    /**
     * Adding new department
     * 
     * @param string $title Departments title
     * @param array $employees Array of employees names
     */
    public static function addDepartment(string $title, array $employees = null)
    {
        $departmentId = static::newDepartment($title);

        if($employees != null){
            static::fillDepartment($departmentId, $employees);
        }
    }
}