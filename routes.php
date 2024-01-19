<?php

use Steampixel\Route;


Route::add('/', function() {
    $blade = new Jenssegers\Blade\Blade('src/views','src/cache');
    echo $blade->make('auth',['title'=>'Авторизация', 'navbar_show'=>false])->render();
}, 'get');


Route::add('/main', function (){
    $blade = new Jenssegers\Blade\Blade('src/views','src/cache');
    echo $blade->make('main', ['navbar_show'=>true])->render();
}, 'get');


Route::add('/tasks', function (){
    $blade = new Jenssegers\Blade\Blade('src/views','src/cache');

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


    $um = new \App\Models\UserModel();
    $users = $um->getAllusers();
    echo $blade->make('tasks', ['navbar_show'=>true, 'boards'=>$boards, 'tasks'=>$tasks, 'users'=>$users, 'statuses'=>$stats])->render();
});


Route::add('/task/([0-9-]*)', function ($id) {

    $tm = new \App\Models\TasksModel();
    $data = $tm->getTaskById($id);
    $tasksStatModel = new \App\Models\TaskStatusModel();
    $stats = $tasksStatModel->getStatusById($data['status']);
    $data['status'] = $stats['name'];

    $data['status'] = [
        "name" => $stats['name'],
        "color" =>$stats['color']
    ];
    $cm = new \App\Models\CommentsModel();
    $comments = $cm->getCommentsByTaskId($id);

    $um = new \App\Models\UserModel();
    $userDataForComments = [];
    foreach ($comments as $comment) {


        $comment['user_data'] = $um->getUserById($comment['user_id']);
    }

    $blade = new Jenssegers\Blade\Blade('src/views','src/cache');
    echo $blade->make('taskDetail', ['navbar_show'=>true, 'currentTask'=>$data, 'comments'=>$comments])->render();
},'get');


Route::add('/profile/([0-9-]*)', function ($id){
    $um = new \App\Models\UserModel();
    $currentUser = $um->getUserById($id);

    $tm = new \App\Models\TasksModel();
    $tasks = $tm->getTaskByUserId($id);

    $blade = new Jenssegers\Blade\Blade('src/views','src/cache');
    echo $blade->make('profile', ['navbar_show'=>true, 'userData'=>$currentUser, 'tasks'=>$tasks])->render();
});

Route::add('/ref', function (){
    $km = new \App\Models\kanbanModel();
    $kanbanList = $km->getAllBoards();

    $blade = new Jenssegers\Blade\Blade('src/views','src/cache');
    echo $blade->make('kanbanRefresh', ['navbar_show'=>true, 'boards'=>$kanbanList])->render();
});

Route::add('/logout', function (){
    $blade = new Jenssegers\Blade\Blade('src/views','src/cache');
    echo $blade->make('profile', ['navbar_show'=>true])->render();
});