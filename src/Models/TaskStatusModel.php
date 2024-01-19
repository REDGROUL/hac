<?php


namespace App\Models;
use  RedBeanPHP as rb;

class TaskStatusModel
{
    public function getAllStatuses()
    {
        return  rb\R::findAll('taskStatus');
    }

    public function getStatusById($id) {
        return rb\R::findOne('taskStatus', 'id = ? ', [$id]);
    }
}