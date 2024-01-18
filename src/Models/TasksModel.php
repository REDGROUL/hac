<?php
namespace App\Models;
use  \RedBeanPHP as rb;

class TasksModel {

    private $database;
//    public function __construct()
//    {
//        rb\R::setup('mysql:host=localhost;dbname=KittyFrame', 'root', '');
//    }

    public function getAllBoard() {

        return rb\R::findAll('kanban');
    }

    public function getAllTasks() {
        return  rb\R::findAll('tasks');
    }

    public function getTaskById($id) {
        return  rb\R::load('tasks', $id);
    }

    public function getTaskByUserId($id) {


        return rb\R::find('tasks', 'worker_id = ? OR owner_id = ?', [$id, $id]);
    }

    public function delTaskById($id) {
        $record = rb\R::load('tasks', $id); // Загрузка записи по id из таблицы
        rb\R::trash($record);



        echo json_encode([
            "status"=>"ok",
        ]);
    }




}