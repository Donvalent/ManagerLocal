<?php

include_once(ROOT . '/components/Db.php');
include_once(ROOT . '/models/Employees.php');

class Tasks
{
    public static function getTasks()
    {
        $tasksList = array();
        $db = Db::getConnection();

        $result = $db->query(
            "SELECT * "
            . "FROM tasks"
        );
        $i = 0;

        while($row = $result->fetch()){
            $tasksList[$i]['id'] = $row['id'];
            $tasksList[$i]['title'] = $row['title'];
            $tasksList[$i]['description'] = $row['description'];
            $tasksList[$i]['worker'] = Employees::getEmployeeById($row['worker']);
            $tasksList[$i]['status'] = static::getStatus($row['status']);
            $tasksList[$i]['date'] = $row['date'];
            $tasksList[$i]['deadline'] = $row['deadline'];
            $i++;
        }

        return $tasksList;
    }

    public static function getTaskById($id)
    {
        $task = array();
        $db = Db::getConnection();

        $result = $db->query(
            "SELECT * "
            . "FROM tasks "
            . "WHERE id = {$id};"
        );

        while($row = $result->fetch()){
            $task['id'] = $row['id'];
            $task['title'] = $row['title'];
            $task['description'] = $row['description'];
            $task['worker'] = Employees::getEmployeeById($row['worker']);
            $task['status'] = static::getStatus($row['status']);
            $task['date'] = $row['date'];
            $task['deadline'] = $row['deadline'];
        }

        return $task;
    }

    public static function updateTask($id, $title, $description, $worker, $status, $date, $deadline)
    {
        $workerId = Employees::getEmployeeByFullName($worker)['id'];
        $db = Db::getConnection();
            
        $sql = "UPDATE tasks "
        . "SET "
        . "title = '{$title}', "
        . "description = '{$description}', "
        . "worker = {$workerId}, "
        . "status = {$status}, "
        . "date = '{$date}', "
        . "deadline = '{$deadline}' "
        . "WHERE tasks.id = '{$id}';";

        $stmt = $db->prepare($sql);
        $stmt->execute();
    }

    public static function addTask($title, $description, $worker, $status, $date, $deadline)
    {
        $workerId = Employees::getEmployeeByFullName($worker)['id'];
        $db = Db::getConnection();
            
        $sql = "INSERT INTO tasks(id, title, description, worker, status, date, deadline) "
        . "VALUES(NULL, '{$title}', '{$description}', {$workerId}, {$status}, '{$date}', '{$deadline}');";

        $stmt = $db->prepare($sql);
        $stmt->execute();
    }

    public static function getStatus($status)
    {
        $result = array();

        if (is_int($status)) {
            $result['id'] = $status;
        
            switch ($status) {
                case '-1':
                    $result['title'] = 'Не выполнено';
                    break;
                case '0':
                    $result['title'] = 'Выполняется';
                    break;
                case '1':
                    $result['title'] = 'Выполнено';
                    break;
                default:
                    return null;
            }
        } else {
            $result['title'] = $status;

            switch ($status) {
                case 'Не выполнено':
                    $result['id'] = -1;
                    break;
                case 'Выполняется':
                    $result['id'] = 0;
                    break;
                case 'Выполнено':
                    $result['id'] = 1;
                    break;
                default:
                    return null;
            }
        }

        return $result;
    }
}