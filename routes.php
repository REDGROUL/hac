<?php

use Steampixel\Route;
use App\Models\DepartmentModel;
session_start();
$blade = new Jenssegers\Blade\Blade('src/views','src/cache');


if(isset($_SESSION['auth'])) {

    Route::add('/tasks', function () use ($blade){
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
        echo $blade->make('tasks', ['title'=>'Задачи','navbar_show'=>true, 'boards'=>$boards, 'tasks'=>$tasks, 'users'=>$users, 'statuses'=>$stats])->render();
    });

    Route::add('/tasks/([0-9-]*)', function ($dep_id) use ($blade){


        $taskModel = new \App\Models\TasksModel();
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
        echo $blade->make('tasks', ['title'=>'Задачи','navbar_show'=>true, 'boards'=>$boards, 'tasks'=>$tasks, 'users'=>$users, 'statuses'=>$stats, 'curent_dep'=>$dep_id])->render();

    });

    Route::add('/task/([0-9-]*)', function ($id) use ($blade) {
        $tc = new \App\Controllers\TaskController();
        $data = $tc->getTask($id);



        $cm = new \App\Models\CommentsModel();
        $comments = $cm->getCommentsByTaskId($data[0]['id']);




        echo $blade->make('taskDetail', ['title'=>'Задача','navbar_show'=>true, 'task'=>$data[0]])->render();
    },'get');

    Route::add('/ref', function () use ($blade){
        $km = new \App\Models\kanbanModel();
        $kanbanList = $km->getAllBoards();
        echo $blade->make('kanbanRefresh', ['title'=>'Редактирование Канбана','navbar_show'=>true, 'boards'=>$kanbanList])->render();

    });


    Route::add('/profile/([0-9-]*)', function ($id) use ($blade){

        $um = new \App\Models\UserModel();
        $currentUser = $um->getUserById($id);
        $tm = new \App\Models\TasksModel();
        $tasks = $tm->getTaskByUserId($id);
        echo $blade->make('profile', ['title'=>'Профиль','navbar_show'=>true, 'userData'=>$currentUser, 'tasks'=>$tasks])->render();

    });


    Route::add('/newUser', fn() => $blade->make('reg', ['title'=>'Регистрация','navbar_show'=>true])->render());
    Route::add('/logout', function (){
        unset($_SESSION['auth']);
        header('Location: /');
    });


    Route::add('/deps', fn()=>$blade->make('dep', ['title'=>'Отделы','navbar_show'=>true, 'deps'=>
        (new DepartmentModel())->getAllDerartments()])->render());
} else {
    Route::add('/',fn()=>$blade->make('auth',['title'=>'Авторизация', 'navbar_show'=>false])->render());
}
