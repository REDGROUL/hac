<?php


namespace App\Controllers;
use  \RedBeanPHP as rb;

class TaskController
{
    public function changeStatus($data) {


      //  rb\R::setup( 'mysql:host=localhost;dbname=kittyFrame','root', '' );
        $taskDb = rb\R::dispense('tasks');

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

    public function newTask($data) {
        $taskDb = rb\R::dispense('tasks');
        $kanban_id = explode("_",$data['kanban_id']);
        $worker_id = explode("_",$data['worker_id']);
        $taskDb->name = $data['name'];
        $taskDb->description = $data['description'];
        $taskDb->owner_id = $data['owner_id'];
        $taskDb->worker_id = end($worker_id);
        $taskDb->kanban_id = end($kanban_id);
        $taskDb->date = $data['date'];
        $taskDb->status = $data['status'];
        $taskDb->task_photo = $data['photo'];


        rb\R::store($taskDb);

        echo json_encode([
            "status"=>"saved",
            "payload"=>[
                "name"=>$data['name'],
                "description"=>$data['description'],
                "kanban_id"=>end($kanban_id)
            ]
        ]);
    }



}