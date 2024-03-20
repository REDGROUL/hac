<?php


namespace App\Controllers;
use App\Models\TasksModel;
use  \RedBeanPHP as rb;

class TaskController extends BaseController
{
    private TasksModel $taskModel;


    function __construct()
    {
        $this->taskModel = new TasksModel();
    }


    public function changeStatus() {

        $data = $this->getInput();

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

    public function delTaskById($id) {
        return json_encode($this->taskModel->delTaskById($id));
    }

    public function updateTask() {
        $data = $this->getInput();
        echo json_encode($data);
        return $this->taskModel->updateTask($data);
    }



}