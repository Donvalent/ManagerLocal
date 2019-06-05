<?php

include_once(ROOT . '/components/Db.php');

class Employees
{
    // *********************
    //    Private functions
    // *********************

    /**
     * Trim fullname to name, surname, lastname
     * 
     * @param string $fullName Employees fullname
     * 
     * @return array Associative array containing
     *              'name', 'surname', 'lastname' elements
     */
    private static function trimName($fullName)
    {
        $tName = explode(' ', $fullName);
        $result = array(
            'name' => $tName[1],
            'surname' => $tName[0],
            'lastname' => $tName[2]
        );

        return $result;
    }

    /**
     * Cut fullname into a shortname 
     * 
     * @param string $fullname Employees fullname
     * 
     * @return string Employees shortname
     */
    private static function getShortName($fullname)
    {
        $tname = static::trimName($fullname);
        return $tname['surname'] . ' ' . mb_substr($tname['name'], 0, 1) . '.' . mb_substr($tname['lastname'], 0, 1) . '.';
    }

    /**
     * Updating employee personal info
     * 
     * @param int $id Employees id
     * @param string $fullname Employees fullname
     * @param string $gender Employees gender
     * @param string $email Employees email
     * @param string $phone Employees phone
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
     * Updating employees departments info
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
            $sql = 'SELECT departments.id '
            . 'FROM departments '
            . 'WHERE departments.title = \'' . $value . '\'';
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
     * Udpating employees positions info
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
    
    /**
     * Filtering the process list
     * 
     * @param array $info Days info
     * 
     * @return array Filtered days info
     */
    private static function filterDaysInfo($info)
    {
        $filterPath = ROOT . '/config/filter_process.php';
        $filter = include($filterPath);

        $result = array();

        foreach ($info as $process => $time) {
            if(!in_array($process, $filter))
                $result[$process] = $time;
        }
                
        return $result;
    }
    

    // *********************
    //    Public functions
    // *********************

    /**
     * Getting list of employees
     * 
     * @return array Associative array containing
     *              'id', 'name', 'surname', 'lastname', 'shortName', 'gender', 'position', 'salary'
     *              'array of departments titles'
     */
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
            $fullname = static::trimName($row['fullName']);

            $employeesList[$i]['id'] = $row['id'];
            $employeesList[$i]['name'] = $fullname['name'];
            $employeesList[$i]['surname'] = $fullname['surname'];
            $employeesList[$i]['lastname'] = $fullname['lastname'];
            $employeesList[$i]['shortName'] = static::getShortName($row['fullName']);
            $employeesList[$i]['gender'] = $row['gender'];
            $employeesList[$i]['position'] = $row['position'];
            $employeesList[$i]['salary'] = $row['salary'];

            // Getting departments list of employee
            $result_Departments = $db->query(
                'SELECT departments.title as department '
                . 'FROM departments '
                . 'JOIN department_staff on department_staff.departments_id = departments.id '
                . 'JOIN users on users.id = department_staff.workers_id '
                . 'WHERE users.id = \'' . $row['id'] . '\';'
            );

            $departments = array();

            // Writing departments list to result array
            while($row_d = $result_Departments->fetch()){    
                array_push($departments,$row_d['department']);     
            }
    

            $employeesList[$i]['departments'] = $departments;

            $i++;
        }

        return $employeesList;
    }

    /**
     * Getting list of employees by deraptment id
     * 
     * @param int $id Departments id
     * 
     * @return array Associative array containing
     *              'id', 'name', 'surname', 'lastname', 'shortName', 'gender', 'position', 'salary'
     *              'array of departments titles'
     */
    public static function getEmployeesListByDepartment($id)
    {
        $employeesList = array();
        $db = Db::getConnection();

        // Getting users info
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
            $fullname = static::trimName($row['fullName']);

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

    /**
     * Getting employee by id
     * 
     * @param int $id Employees id
     * 
     * @return array Associative array containing
     *              'id', 'name', 'surname', 'lastname', 'shortName', 'gender', 'position', 'salary'
     *              'array of departments titles'
     */
    public static function getEmployeeById($id)
    {
        $employee = array();
        $db = Db::getConnection();

        // Getting users info
        $result = $db->query(
            'SELECT users.fullName, users.phone, users.email, users.gender, positions.title as position, positions.salary '
            . 'FROM users '
            . 'JOIN positions on positions.id = users.position '
            . 'WHERE users.id = \''.$id.'\';'
        );

        while($row = $result->fetch()){

            $fullname = static::trimName($row['fullName']);

            $employee['id'] = $id;
            $employee['name'] = $fullname['name'];
            $employee['surname'] = $fullname['surname'];
            $employee['lastname'] = $fullname['lastname'];
            $employee['shortName'] = static::getShortName($row['fullName']);
            $employee['phone'] = $row['phone'];
            $employee['email'] = $row['email'];
            $employee['gender'] = $row['gender'];
            $employee['position'] = $row['position'];
            $employee['salary'] = $row['salary'];
        }

        // Getting departments info
        $result_Departments = $db->query(
            'SELECT departments.title as department '
            . 'FROM departments '
            . 'JOIN department_staff on department_staff.departments_id = departments.id '
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

    public static function getEmployeeByFullName($fullName)
    {
        $employee = array();
        $db = Db::getConnection();

        // Getting users info
        $result = $db->query(
            'SELECT users.fullName, users.id, users.phone, users.email, users.gender, positions.title as position, positions.salary '
            . 'FROM users '
            . 'JOIN positions on positions.id = users.position '
            . "WHERE users.fullName = '{$fullName}';"
        );

        while($row = $result->fetch()){

            $fullname = static::trimName($row['fullName']);

            $employee['id'] = $row['id'];
            $employee['name'] = $fullname['name'];
            $employee['surname'] = $fullname['surname'];
            $employee['lastname'] = $fullname['lastname'];
            $employee['shortName'] = static::getShortName($row['fullName']);
            $employee['phone'] = $row['phone'];
            $employee['email'] = $row['email'];
            $employee['gender'] = $row['gender'];
            $employee['position'] = $row['position'];
            $employee['salary'] = $row['salary'];
        }

        return $employee;
    }

    /**
     * Updating employees info
     * 
     * @param int $id Employees id
     * @param string $fullname Employees fullname
     * @param string $gender Employees gender
     * @param string $email Employees email
     * @param string $phone Employees phone
     * @param string $position Employees position title
     * @param int $salary Employees salary
     * @param array $departments Associative array containing 'title'
     */
    public static function updateEmployee(int $id, $fullname, string $gender, string $email, string $phone, string $position, int $salary, array $departments)
    {

        $employee = static::getEmployeeById($id);
        static::updatePersonalInfo($id, $fullname, $gender, $email, $phone);
        static::updateEmpPosInfo($id, $position, $salary);
        static::updateEmpDepInfo($id, $departments);
    }

    /**
     * Getting Employees all days info by id
     * 
     * @param int $id Employees id
     * 
     * @return array Associative array containing
     *               'date', 'info'
     */
    public static function getDaysInfo($id)
    {
        $daysInfo = array();
        $db = Db::getConnection();

        // Getting users info
        $result = $db->query(
            'SELECT date, info '
            . 'FROM days_info '
            . "WHERE users_id = {$id}"
        );

        $daysInfo = $result->fetch(PDO::FETCH_ASSOC);

        return $daysInfo;
    }

    /**
     * Getting Employees days info by date
     * 
     * @param int $id Employees id
     * @param string $date Date
     * 
     * @return array Associative array containing
     *               'date', 'info'
     */
    public static function getDaysInfoByDate($id, $date)
    {
        $daysInfo = array();
        $db = Db::getConnection();

        // Getting users info
        $result = $db->query(
            'SELECT info '
            . 'FROM days_info '
            . "WHERE users_id = {$id} AND date = '{$date}'"
        );

        while($row = $result->fetch(PDO::FETCH_ASSOC))
            $daysInfo = json_decode($row['info'], true);
        
        $daysInfo = static::filterDaysInfo($daysInfo);

        return $daysInfo;
    }

    /**
     * Adding new employee
     * 
     * @param
     */
    public static function addEmployee(string $fullname, string $gender, string $email, string $position, int $salary, array $departments)
    {
        
    }

    public static function isIsset($login)
    {
        $db = Db::getConnection();
            
        $sql = "SELECT users.id "
        . "FROM users "
        . "LEFT JOIN login on login.id = users.id "
        . "WHERE login.login = '{$login}';";

        $stmt = $db->prepare($sql);
        $stmt->execute();
        while ($row = $stmt->fetch()) {
            return $row['id'];
        }
    }

    public static function isAuthentication($login, $password)
    {
        $db = Db::getConnection();
        $result = array();    

        $sql = "SELECT login.id, login.admin "
        . "FROM users "
        . "LEFT JOIN login on login.id = users.id "
        . "WHERE login.login = '{$login}' AND login.password = '{$password}';";

        $stmt = $db->prepare($sql);
        $stmt->execute();
        while ($row = $stmt->fetch()) {
            $result['id'] = $row['id'];
            $result['admin'] = $row['admin'];
        }
        return $result;
    }
}