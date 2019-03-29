<?php

include_once(ROOT . '/components/Db.php');

class Departments
{
    // *********************
    //    Private function
    // *********************

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

    /**
     * SQL request for adding new department
     * 
     * @param string $title Department title
     * @return int Department new id
     */
    private static function newDepartment($title)
    {
        $db = Db::getConnection();
        $sql =
        'INSERT INTO '
        . 'departmens '
            . '(id, title) '
        . 'VALUES '
            . '(NULL, \'' . $title . '\')';

        $stmt = $db->prepare($sql);
        $stmt->execute();

        $sql = 
        'SELECT departmens.id '
        . 'FROM departmens '
        . 'WHERE departmens.title = \'' . $title . '\' ';

        $stmt = $db->prepare($sql);
        $stmt->execute();
        while ($row = $stmt->fetch()) {
            return $row['id'];
        }
    }

    /**
     * Fill the department
     * 
     * @param int $departmentId Departments id
     * @param array $employees New department employees
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

    public static function getDepartmentsList()
    {
        $departments = array();
        $db = Db::getConnection();
        
        $result = $db->query(
            'SELECT departmens.id, departmens.title '
            . 'FROM departmens'
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

    public static function getDepartmentById($departmentId)
    {
        $department = array();

        $db = Db::getConnection();
        
        $result = $db->query(
            'SELECT departmens.id, departmens.title '
            . 'FROM departmens '
            . 'WHERE departmens.id = '. $departmentId .';'
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
     * Add new department
     * 
     * @param string $title Department title
     * @param array $employees Department employees
     */
    public static function addDepartment(string $title, array $employees = null)
    {
        $departmentId = static::newDepartment($title);

        if($employees != null){
            static::fillDepartment($departmentId, $employees);
        }
    }
}