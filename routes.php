<?php

use Steampixel\Route;
session_start();
$blade = new Jenssegers\Blade\Blade('src/views','src/cache');
Route::add('/', function() use ($blade){
    echo $blade->make('auth',['title'=>'Авторизация', 'navbar_show'=>false])->render();
}, 'get');

Route::add('/tasks', function () use ($blade){
    if($_SESSION['auth']) {
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
    } else {
        header('Location: /');
    }

});

Route::add('/tasks/([0-9-]*)', function ($dep_id) use ($blade){


    if($_SESSION['auth']) {
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
    } else {
        header('Location: /');
    }

});

Route::add('/task/([0-9-]*)', function ($id) use ($blade) {
    if(!$_SESSION['auth']) {
        header('Location: /');

    }
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

    var_dump($comments);
    $um = new \App\Models\UserModel();
    $userDataForComments = [];
    foreach ($comments as $comment) {
        $comment['user_data'] = $um->getUserById($comment['user_id']);
    }


    echo $blade->make('taskDetail', ['title'=>'Задача','navbar_show'=>true, 'currentTask'=>$data, 'comments'=>$comments])->render();
},'get');


//Route::add('/task/([0-9-]*)', function ($id) use ($blade) {
//    if($_SESSION['auth']) {
//        $tm = new \App\Models\TasksModel();
//        $data = $tm->getTaskById($id);
//        $tasksStatModel = new \App\Models\TaskStatusModel();
//        $stats = $tasksStatModel->getStatusById($data['status']);
//        $data['status'] = $stats['name'];
//
//        $data['status'] = [
//            "name" => $stats['name'],
//            "color" => $stats['color']
//        ];
//        $cm = new \App\Models\CommentsModel();
//        $comments = $cm->getCommentsByTaskId($id);
//
//        $um = new \App\Models\UserModel();
//        $userDataForComments = [];
//        foreach ($comments as $comment) {
//            $comment['user_data'] = $um->getUserById($comment['user_id']);
//        }
//    } else {
//        header('Location: /');
//    }
//
//
//    echo $blade->make('taskDetail', ['title'=>'Задача','navbar_show'=>true, 'currentTask'=>$data, 'comments'=>$comments])->render();
//},'get');




Route::add('/profile/([0-9-]*)', function ($id) use ($blade){
    if($_SESSION['auth']) {
        $um = new \App\Models\UserModel();
        $currentUser = $um->getUserById($id);
        $tm = new \App\Models\TasksModel();
        $tasks = $tm->getTaskByUserId($id);
        echo $blade->make('profile', ['title'=>'Профиль','navbar_show'=>true, 'userData'=>$currentUser, 'tasks'=>$tasks])->render();
    } else {
        header('Location: /');
    }

});

Route::add('/ref', function () use ($blade){
    if($_SESSION['auth']) {
        $km = new \App\Models\kanbanModel();
        $kanbanList = $km->getAllBoards();
        echo $blade->make('kanbanRefresh', ['title'=>'Редактирование Канбана','navbar_show'=>true, 'boards'=>$kanbanList])->render();
    } else {
        header('Location: /');
    }


});
Route::add('/newUser', function () use ($blade){
    echo $blade->make('reg', ['title'=>'Регистрация','navbar_show'=>true])->render();
});
Route::add('/logout', function () use ($blade){
    unset($_SESSION['auth']);
    header('Location: /');
});

Route::add('/chat', function () use ($blade){
    echo $blade->make('chat', ['title'=>'чат','navbar_show'=>true])->render();
});

Route::add('/deps', function () use ($blade){
    $dm = new \App\Models\DepartmentModel();
    $deps = $dm->getAllDerartments();
    echo $blade->make('dep', ['title'=>'Отделы','navbar_show'=>true, 'deps'=>$deps])->render();
});

