<?php


namespace App\Controllers;
use App\Models\CommentsModel;
use App\Models\TasksModel;
use Jenssegers\Blade\Blade;
use  \RedBeanPHP as rb;

class TaskController extends BaseController
{
    private TasksModel $taskModel;
    private CommentsModel $commentModel;
    private Blade $blade;

    function __construct()
    {
        $this->taskModel = new TasksModel();
        $this->commentModel = new CommentsModel();
        $this->blade = new Blade('src/views','src/cache');
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

    public function getTask($id) {
        return $this->taskModel->getTask($id);
    }


    public function getPrepareTasks() {
        $taskModel = new \App\Models\TasksModel();
        $boards = $taskModel->getAllBoard();
        $tasks = $taskModel->getAllTasksByDepartmentAndUseId($_SESSION['dep'], $_SESSION['uid']);
        $tasksStatModel = new \App\Models\TaskStatusModel();
        $stats = $tasksStatModel->getAllStatuses();
        foreach ($tasks as $task) {
            $task['status'] = [
                "name" => $stats[$task['status']]['name'],
                "color" =>$stats[$task['status']]['color'],
            ];
        }


        $um = new \App\Models\UserModel() ;
        $users = $um->getAllusers();
        return $this->blade->make('tasks', ['title'=>'Задачи','navbar_show'=>true, 'boards'=>$boards, 'tasks'=>$tasks, 'users'=>$users, 'statuses'=>$stats])->render();
    }

    public function getDetailTask($id) {
        $data = $this->getTask($id)[0];
        $comments = $this->commentModel->getCommentsByTaskId($data[0]['id']);
        return $this->blade->make('taskDetail', ['title'=>'Задача','navbar_show'=>true, 'task'=>$data])->render();
    }

    public function getPrepareKanbanById($dep_id) {
        $taskModel = new TasksModel();
        $boards = $taskModel->getAllBoard();
        $tasks = $taskModel->getAllTasksByDepartment($dep_id);
        $tasksStatModel = new \App\Models\TaskStatusModel();
        $stats = $tasksStatModel->getAllStatuses();
        foreach ($tasks as $task) {
            $task['status'] = [
                "name" => $stats[$task['status']]['name'],
                "color" =>$stats[$task['status']]['color'],
            ];
        }


        $um = new \App\Models\UserModel() ;
        $users = $um->getAllusers();
        return $this->blade->make('tasks', ['title'=>'Задачи','navbar_show'=>true, 'boards'=>$boards, 'tasks'=>$tasks, 'users'=>$users, 'statuses'=>$stats, 'curent_dep'=>$dep_id])->render();
    }
}