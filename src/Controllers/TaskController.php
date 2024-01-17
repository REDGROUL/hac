<?php


namespace App\Controllers;
use  \RedBeanPHP as rb;

class TaskController
{
    public function changeStatus($data) {


        rb\R::setup( 'mysql:host=localhost;dbname=kittyFrame','root', '' );
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
}