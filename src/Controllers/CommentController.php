<?php


namespace App\Controllers;


use App\Models\CommentsModel;

class CommentController extends BaseController
{
    private CommentsModel $commentModel;

    function __construct()
    {
        $this->commentModel = new CommentsModel();
    }

    public function getCommentsByTaskId($id) {
        return json_encode($this->getCommentsByTaskId($id));
    }

    public function addNewComment() {
        $json = $this->getInput();
        return json_encode($this->commentModel->addNewComment($json));
    }


}