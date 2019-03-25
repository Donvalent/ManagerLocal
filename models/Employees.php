<?php

include_once(ROOT . '/components/Db.php');

class Employees
{
    private static function cutName($fullName)
    {
        $cutter = explode(' ', $fullName);
        $cutFullName = array(
            'name' => $cutter[1],
            'surname' => $cutter[0],
            'lastname' => $cutter[2]
        );

        return $cutFullName;
    }

    private static function updatePersonalInfo($id, $fullname, $gender, $email, $phone)
    {
        $db = Db::getConnection();
        $sql =
        'UPDATE users '
        . 'SET '
            . 'fullName = \'' . $fullname . '\', '
            . 'gender = \'' . $gender . '\', '
            . 'phone = \'' . $phone . '\', '
            . 'email = \'' . $email. '\' '
        . 'WHERE users.id = \'' . $id . '\'; ';

        $stmt = $db->prepare($sql);
        $stmt->execute();    
    }

    private static function updateEmpInfoOfDep($id, int $position, int $salary, array $departments)
    {
        $db = Db::getConnection();
        $sql = '';

        $stmt = $db->prepare($sql);
        $stmt->execute();
    }

    public static function getEmployeesList()
    {
        $employeesList = array();
        $db = Db::getConnection();

        $result = $db->query(
            'SELECT users.id, users.fullName, users.gender, positions.title as position, positions.salary '
            . 'FROM users '
            . 'JOIN positions on positions.id = users.id '
            );

        $i = 0;
        while($row = $result->fetch()){

            $fullname = static::cutName($row['fullName']);

            $employeesList[$i]['id'] = $row['id'];
            $employeesList[$i]['name'] = $fullname['name'];
            $employeesList[$i]['surname'] = $fullname['surname'];
            $employeesList[$i]['lastname'] = $fullname['lastname'];
            $employeesList[$i]['gender'] = $row['gender'];
            $employeesList[$i]['position'] = $row['position'];
            $employeesList[$i]['salary'] = $row['salary'];

            $result_Departments = $db->query(
                'SELECT departmens.title as department '
                . 'FROM departmens '
                . 'JOIN department_staff on department_staff.departments_id = departmens.id '
                . 'JOIN users on users.id = department_staff.workers_id '
                . 'WHERE users.id = \'' . $row['id'] . '\';'
            );

            $departments = array();


            while($row_d = $result_Departments->fetch()){    
                array_push($departments,$row_d['department']);     
            }
    

            $employeesList[$i]['departments'] = $departments;

            $i++;
        }

        return $employeesList;
    }

    public static function getEmployeeById($id)
    {
        $employee = array();
        $db = Db::getConnection();

        $result = $db->query(
            'SELECT users.fullName, users.phone, users.email, users.gender, positions.title as position, positions.salary '
            . 'FROM users '
            . 'JOIN positions on positions.id = users.position '
            . 'WHERE users.id = \''.$id.'\';'
        );

        while($row = $result->fetch()){

            $fullname = static::cutName($row['fullName']);

            $employee['id'] = $id;
            $employee['name'] = $fullname['name'];
            $employee['surname'] = $fullname['surname'];
            $employee['lastname'] = $fullname['lastname'];
            $employee['phone'] = $row['phone'];
            $employee['email'] = $row['email'];
            $employee['gender'] = $row['gender'];
            $employee['position'] = $row['position'];
            $employee['salary'] = $row['salary'];
        }

        $result_Departments = $db->query(
            'SELECT departmens.title as department '
            . 'FROM departmens '
            . 'JOIN department_staff on department_staff.departments_id = departmens.id '
            . 'JOIN users on users.id = department_staff.workers_id '
            . 'WHERE users.id = \'' . $id . '\';'
        );

        $departments = array();


        while($row_d = $result_Departments->fetch()){
            array_push($departments,$row_d['department']);   
        }

        $employee['departments'] = $departments;

        return $employee;
    }

    public static function updateEmployee(int $id, $fullname, string $gender, string $email, string $phone)
    {
        static::updatePersonalInfo($id, $fullname, $gender, $email, $phone);
    }
}