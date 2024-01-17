<?php
namespace App\Models;
use  \RedBeanPHP as rb;

class TasksModel {


    public function __construct() {
        rb\R::setup( 'mysql:host=localhost;dbname=kittyFrame','root', '' );
        $this->usersdb = rb\R::dispense('kanban');
    }

    public function getAllBoard() {
        $all =  rb\R::findAll('kanban');


        return $all;
    }

    public function getAllTasks() {
        $allTasks =  rb\R::findAll('tasks');
        return $allTasks;
    }


}