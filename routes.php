<?php

use Steampixel\Route;
session_start();
$blade = new Jenssegers\Blade\Blade('src/views','src/cache');
Route::add('/', function() use ($blade){
    echo $blade->make('auth',['title'=>'Авторизация', 'navbar_show'=>false])->render();
}, 'get');


Route::add('/main', function () use ($blade){
    echo $blade->make('main', ['navbar_show'=>true])->render();
}, 'get');


Route::add('/tasks', function () use ($blade){
    if($_SESSION['auth']) {
        $taskModel = new \App\Models\TasksModel();
        $boards = $taskModel->getAllBoard();
        $tasks = $taskModel->getAllTasks();
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
        echo $blade->make('tasks', ['navbar_show'=>true, 'boards'=>$boards, 'tasks'=>$tasks, 'users'=>$users, 'statuses'=>$stats])->render();
    } else {
        header('Location: /');
    }

});


Route::add('/task/([0-9-]*)', function ($id) use ($blade) {
    if($_SESSION['auth']) {
        $tm = new \App\Models\TasksModel();
        $data = $tm->getTaskById($id);
        $tasksStatModel = new \App\Models\TaskStatusModel();
        $stats = $tasksStatModel->getStatusById($data['status']);
        $data['status'] = $stats['name'];

        $data['status'] = [
            "name" => $stats['name'],
            "color" => $stats['color']
        ];
        $cm = new \App\Models\CommentsModel();
        $comments = $cm->getCommentsByTaskId($id);

        $um = new \App\Models\UserModel();
        $userDataForComments = [];
        foreach ($comments as $comment) {
            $comment['user_data'] = $um->getUserById($comment['user_id']);
        }
    } else {
        header('Location: /');
    }


    echo $blade->make('taskDetail', ['navbar_show'=>true, 'currentTask'=>$data, 'comments'=>$comments])->render();
},'get');


Route::add('/profile/([0-9-]*)', function ($id) use ($blade){
    if($_SESSION['auth']) {
        $um = new \App\Models\UserModel();
        $currentUser = $um->getUserById($id);
        $tm = new \App\Models\TasksModel();
        $tasks = $tm->getTaskByUserId($id);
        echo $blade->make('profile', ['navbar_show'=>true, 'userData'=>$currentUser, 'tasks'=>$tasks])->render();
    } else {
        header('Location: /');
    }

});

Route::add('/ref', function () use ($blade){
    if($_SESSION['auth']) {
        $km = new \App\Models\kanbanModel();
        $kanbanList = $km->getAllBoards();
        echo $blade->make('kanbanRefresh', ['navbar_show'=>true, 'boards'=>$kanbanList])->render();
    } else {
        header('Location: /');
    }


});
Route::add('/newUser', function () use ($blade){
    echo $blade->make('reg', ['navbar_show'=>true])->render();
});
Route::add('/logout', function () use ($blade){
    echo $blade->make('profile', ['navbar_show'=>true])->render();
});

Route::add('/chat', function () use ($blade){
    echo $blade->make('chat', ['navbar_show'=>true])->render();
});