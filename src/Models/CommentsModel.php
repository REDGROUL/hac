<?php

namespace App\Models;

use  \RedBeanPHP as rb;

class CommentsModel
{

    public function getCommentsByTaskId($id)
    {
        return rb\R::find('comments', 'task_id = ?', [$id]);
    }

    public function addNewComment($data) {
        $taskDb = rb\R::dispense('comments');


        $taskDb->user_id = $data['user_id'];
        $taskDb->task_id = $data['task_id'];
        $taskDb->text = $data['text'];
        $taskDb->date =  date('Y-m-d H:i:s');

        try {
            rb\R::store($taskDb);
            return json_encode([
                "status"=>"saved",
                "payload"=>[
                    "user_id"=>$data['user_id'],
                    "text"=>$data['text'],
                    "task_id"=>$data['task_id']
                ]
            ]);
        } catch (rb\RedException\SQL $e) {
            return $e->getMessage();
        }


    }
}