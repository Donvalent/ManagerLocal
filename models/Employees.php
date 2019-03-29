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
    private static function getShortName($fullname)
    {
        $cutName = static::cutName($fullname);
        return $cutName['surname'] . '.' . mb_substr($cutName['name'], 0, 1) . '.' . mb_substr($cutName['lastname'], 0, 1);
    }
    /**
     * Updating employee personal info
     */
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
    /**
     * Updating employee departments info
     * 
     * @param int $id Employees id
     * @param array $departments Departments titles
     */
    private static function updateEmpDepInfo($id, array $departments)
    {
        $db = Db::getConnection();
        
        // Удаление сотрудника из всех отделов
        $sql = 'DELETE FROM department_staff '
        . 'WHERE department_staff.workers_id = '. $id .';';

        $stmt = $db->prepare($sql);
        $stmt->execute();

        foreach ($departments as $department => $value)
        {
            // Получение id отдела
            $sql = 'SELECT departmens.id '
            . 'FROM departmens '
            . 'WHERE departmens.title = \'' . $value . '\'';
            $stmt = $db->prepare($sql);
            $stmt->execute();

            // Запись в этот отдел сотрудника
            while($row = $stmt->fetch()){
                $sql = 'INSERT INTO department_staff(department_staff.departments_id, department_staff.workers_id) '
                . 'VALUES ('. $row['id'] .', '. $id .');';

                $stmt = $db->prepare($sql);
                $stmt->execute();
            }
        }
    }
    /**
     * Udpating employee positions info
     * 
     * @param int $id Employee id
     * @param string $position Employee positions title
     * @param int $salary Employee salary
     */
    private static function updateEmpPosInfo($id, $position, $salary)
    {
        $db = Db::getConnection();
        $sql = 'UPDATE positions '
        . 'SET '
            . 'title = \'' . $position . '\', '
            . 'salary = \'' . $salary . '\' '
        . 'WHERE id = \'' . $id . '\';';

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
            $employeesList[$i]['shortName'] = static::getShortName($row['fullName']);
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

    public static function getEmployeesListByDepartment($id)
    {
        $employeesList = array();
        $db = Db::getConnection();

        $sql =
        'SELECT users.id, users.fullName, users.gender, positions.title '
        . 'FROM users '

        . 'LEFT JOIN positions '
        . 'ON positions.id = users.id '

        . 'LEFT JOIN department_staff '
        . 'ON department_staff.workers_id = users.id '

        . 'WHERE department_staff.departments_id =' . $id .';';

        $stmt = $db->prepare($sql);
        $stmt->execute();

        $i = 0;

        while ($row = $stmt->fetch())
        {
            $fullname = static::cutName($row['fullName']);

            $employeesList[$i]['id'] = $row['id'];
            $employeesList[$i]['name'] = $fullname['name'];
            $employeesList[$i]['surname'] = $fullname['surname'];
            $employeesList[$i]['lastname'] = $fullname['lastname'];
            $employeesList[$i]['shortName'] = static::getShortName($row['fullName']);
            $employeesList[$i]['gender'] = $row['gender'];
            $employeesList[$i]['position'] = $row['title'];
            
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

    public static function updateEmployee(int $id, $fullname, string $gender, string $email, string $phone, string $position, int $salary, array $departments)
    {
        $employee = static::getEmployeeById($id);
        static::updatePersonalInfo($id, $fullname, $gender, $email, $phone);
        static::updateEmpPosInfo($id, $position, $salary);
        static::updateEmpDepInfo($id, $departments);
    }
}