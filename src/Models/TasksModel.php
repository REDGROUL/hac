<?php

namespace App\Models;

use Exception;
use  \RedBeanPHP as rb;

class TasksModel
{

    public function getAllBoard()
    {

        return rb\R::findAll('kanban');
    }

    public function getAllTasks()
    {
        return rb\R::findAll('tasks');
    }

    public function getAllTasksByDepartment($dep_id)
    {
        return rb\R::findAll('tasks', 'dep_id = ?', [$dep_id]);
    }

    public function getAllTasksByDepartmentAndUseId($dep_id, $user_id)
    {
        return rb\R::findAll('tasks', 'dep_id = ? OR worker_id = ? OR owner_id = ?', [$dep_id, $user_id, $user_id]);
    }


    public function getTaskByUserId($id)
    {
        return rb\R::find('tasks', 'worker_id = ? OR owner_id = ?', [$id, $id]);
    }

    public function delTaskById($id)
    {
        $record = rb\R::load('tasks', $id); // Загрузка записи по id из таблицы
        rb\R::trash($record);

        return json_encode([
            "status" => "ok",
        ]);
    }

    public function updateTask($data)
    {
        $currentTask = rb\R::load('tasks', $data['task_id']);

        $worker_id = explode("_", $data['worker']);
        $currentTask->name = $data['name'];
        $currentTask->description = $data['description'];
        $currentTask->date = $data['date'];
        $currentTask->dep_id = $data['dep_id'];
        $currentTask->worker_id = end($worker_id);
        $currentTask->status = $data['status'];

        try {

            rb\R::store($currentTask);
            return json_encode(["status" => "ok"]);
        } catch (Exception $e) {
            echo $e->getMessage();
            return json_encode(["status" => "bad"]);

        }
    }


    public function getTask(int $id) {

        return (rb\R::getAll("SELECT tasks.id, tasks.name, tasks.description, tasks.date_open, tasks.date, 
                                    department.name AS department_name, kanban.name AS kanban, worker.name AS worker, worker.id AS worker_id, 
                                    owner.name AS owner, owner.id AS owner_id, taskStatus.name AS current_status, taskStatus.color AS color_status 
                                    FROM tasks 
                                                JOIN department ON tasks.dep_id = department.id
                                                JOIN kanban ON tasks.kanban_id = kanban.id
                                                JOIN users AS worker ON tasks.worker_id = worker.id
                                                JOIN users AS owner ON tasks.owner_id = owner.id
                                                JOIN taskStatus ON tasks.status = taskStatus.id
                                                WHERE tasks.id = '$id';"));
    }

    public function newTask() {
        if(!($_FILES['file']['size'] > 0)) {
            $_POST['photo'] = "res/images/noimage.jpg";
        }

        $uploaddir = 'res/images/';
        $uploadfile = $uploaddir . basename($_FILES['file']['name']);

        if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
            $_POST['photo'] = $uploadfile;
        }


        $taskDb = rb\R::dispense('tasks');
        $kanban_id = explode("_",$_POST['kanban_id']);
        $worker_id = explode("_",$_POST['worker_id']);
        $taskDb->name = $_POST['name'];
        $taskDb->description = $_POST['description'];
        $taskDb->owner_id = $_POST['owner_id'];
        $taskDb->worker_id = end($worker_id);
        $taskDb->kanban_id = end($kanban_id);
        $taskDb->date = $_POST['date'];
        $taskDb->status = $_POST['status'];
        $taskDb->task_photo = $_POST['photo'];
        $taskDb->date_open = date("Y-m-d H:i");
        $taskDb->dep_id = $_POST['dep_id'];


        try {
            rb\R::store($taskDb);
            return json_encode([
                "status"=>"saved",
                "payload"=>[
                    "name"=>$_POST['name'],
                    "description"=>$_POST['description'],
                    "kanban_id"=>end($kanban_id)
                ]
            ]);
        } catch (rb\RedException\SQL $e) {
            return json_encode($e->getMessage());
        }
    }

    public function changeStatus($data) {
        $currentTask = rb\R::load('tasks', $data['taskId']);
        $currentTask->kanban_id = $data['kanban_id'];
        rb\R::store($currentTask);

        return json_encode([
            "status"=>"ok",
            "payload"=>[
                "message"=>"task status updated"
            ]
        ]);
    }
}