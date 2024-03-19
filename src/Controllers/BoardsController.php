<?php


namespace App\Controllers;


use App\Models\kanbanModel;

class BoardsController extends BaseController
{
    private kanbanModel $kanbanModel;

    function __construct()
    {
        $this->kanbanModel = new kanbanModel();
    }

    public function addBoard() {
        $json = $this->getInput();
        return $this->kanbanModel->addBoard($json);
    }
    public function getAllBoards() {
        return $this->kanbanModel->getAllBoards();
    }
    public function delBoard() {
        $json = $this->getInput();
        return $this->kanbanModel->delBoard($json);
    }
}