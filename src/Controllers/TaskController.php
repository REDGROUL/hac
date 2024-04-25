<?php

namespace App\Controllers;

use App\Models\CommentsModel;
use App\Models\TasksModel;
use App\Models\TaskStatusModel;
use App\Models\UserModel;

use App\Service\Impl\UserServiceImpl;
use App\Service\Interfaces\UserService;
use Jenssegers\Blade\Blade;


class TaskController extends BaseController
{
    private TasksModel $taskModel;
    private TaskStatusModel $taskStatusModel;
    private CommentsModel $commentModel;
    private UserService $userService;
    private Blade $blade;

    function __construct()
    {
        $this->taskModel = new TasksModel();
        $this->commentModel = new CommentsModel();
        $this->taskStatusModel = new TaskStatusModel();
        $this->userService = new UserServiceImpl();
        $this->blade = new Blade('src/views', 'src/cache');
    }


    public function changeStatus()
    {
        $data = $this->getInput();
        return $this->taskModel->changeStatus($data);
    }

    public function newTask()
    {

        return $this->taskModel->newTask();
    }

    public function delTaskById($id)
    {
        return json_encode($this->taskModel->delTaskById($id));
    }

    public function updateTask()
    {
        $data = $this->getInput();
        echo json_encode($data);
        return $this->taskModel->updateTask($data);
    }

    public function getTask($id)
    {
        return $this->taskModel->getTask($id);
    }

    public function getDetailTask($id)
    {

        $data = $this->getTask($id)[0];
        $comments = $this->commentModel->getCommentsByTaskId($data['id']);

        $data['comments'] = $comments;
        $this->setRedisData("taskDetail_" . $id, json_encode($data));

        return $this->blade->make('taskDetail', ['title' => 'Задача', 'navbar_show' => true, 'task' => $data,
            'comments' => $data['comments']])->render();
    }

    public function getPrepareKanbanById($dep_id)
    {

        $boards = $this->taskModel->getAllBoard();
        $tasks = $this->taskModel->getAllTasksByDepartment($dep_id);
        $stats = $this->taskStatusModel->getAllStatuses();
        foreach ($tasks as $task) {
            $task['status'] = [
                "name" => $stats[$task['status']]['name'],
                "color" => $stats[$task['status']]['color'],
            ];
        }
        $users = $this->userService->findAllUser();
        return $this->blade->make('tasks', ['title' => 'Задачи', 'navbar_show' => true, 'boards' => $boards, 'tasks' => $tasks, 'users' => $users, 'statuses' => $stats, 'curent_dep' => $dep_id])->render();
    }
}