<?php


namespace App\Models;
use  RedBeanPHP as rb;


class kanbanModel
{

    public function getAllBoards() {
        return  rb\R::findAll('kanban');
    }

    public function addBoard($data) {
        $db = rb\R::dispense('kanban');


        $db->name = $data['name'];
        $db->description = $data['descr'];


        rb\R::store($db);

        echo json_encode([
            "status"=>"saved",
        ]);
    }


    public function delBoard($data) {

        $record = rb\R::load('kanban', $data['id']); // Загрузка записи по id из таблицы
        rb\R::trash($record);



        echo json_encode([
            "status"=>$data['id'],
        ]);
    }

}