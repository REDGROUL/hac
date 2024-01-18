<?php
use Steampixel\Route;

Route::add('/login', function (){

    $json = json_decode(file_get_contents("php://input"), true);
    if(!empty($json) && $json['type'] == 'auth')
    {
        $uc = new \App\Controllers\UserController();
        $uc->login($json);
    }
    else
    {
        echo json_encode([
            "Message from api"=>"yo wtf?"
        ]);
    }

}, 'post');

Route::add('/tasks/changeStatus', function (){
    $json = json_decode(file_get_contents("php://input"), true);
    if(!empty($json) && $json['type'] == 'changeStatus')
    {
        $tc = new \App\Controllers\TaskController();
        $tc->changeStatus($json);
    }
}, 'post');


Route::add('/tasks/newTask', function (){
    $json = json_decode(file_get_contents("php://input"), true);
    if(!empty($json) && $json['type'] == 'newTask')
    {
        $tc = new \App\Controllers\TaskController();
        $tc->newTask($json);
    }
}, 'post');

Route::add('/addNewComment', function (){
    $json = json_decode(file_get_contents("php://input"), true);
    if(!empty($json) && $json['type'] == 'newComment')
    {
        $tc = new \App\Models\CommentsModel();
        $tc->addNewComment($json);
    }
}, 'post');

Route::add('/addBoard', function (){
    $json = json_decode(file_get_contents("php://input"), true);
    if(!empty($json) && $json['type'] == 'addBoard')
    {
        $tc = new \App\Models\kanbanModel();
        $tc->addBoard($json);
    }
}, 'post');

Route::add('/delboard', function (){
    $json = json_decode(file_get_contents("php://input"), true);
    if(!empty($json) && $json['type'] == 'delete')
    {
        $tc = new \App\Models\kanbanModel();
        $tc->delBoard($json);
    }
}, 'post');
Route::add('/deltask', function (){
    $json = json_decode(file_get_contents("php://input"), true);
    if(!empty($json) && $json['type'] == 'deltask')
    {
        $tc = new \App\Models\TasksModel();
        $tc->delTaskById($json['id']);
    }
}, 'post');