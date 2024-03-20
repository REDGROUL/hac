<?php

use App\Controllers\BoardsController;
use App\Controllers\CommentController;
use App\Controllers\DepartmentController;
use App\Controllers\TaskController;
use App\Controllers\UserController;
use App\Models\DepartmentModel;
use App\Models\TasksModel;
use App\Models\UserModel;
use Steampixel\Route;

Route::add('/login', function (){
    $uc = new UserController();
    echo $uc->login();
}, 'post');

if($_SESSION['auth']) {

    Route::add('/tasks/changeStatus', function (){
        $tc = new TaskController();
        echo $tc->changeStatus();
    }, 'post');

    Route::add('/tasks/newTask', function (){
        $tc = new TaskController();
        echo $tc->newTask();
    }, 'post');

    Route::add('/addNewComment', function (){
        $CommentContr = new CommentController();
        echo $CommentContr->addNewComment();
    }, 'post');

    Route::add('/addBoard', function (){
        $boardController = new BoardsController();
        echo $boardController->addBoard();
    }, 'post');

    Route::add('/delboard', function (){
        $boardController = new BoardsController();
        echo $boardController->delBoard();
    }, 'post');

    Route::add('/delTask/([0-9-]*)', function ($id){
        $tc = new TaskController();
        echo $tc->delTaskById($id);
    }, 'post');

    Route::add('/addUser', function (){
        $um = new UserController();
        echo $um->addUser();
    }, 'post');

    Route::add('/addDep', function (){
        $dm = new DepartmentController();
        echo $dm->createDep();
    }, 'post');

    Route::add('/getUserByDep/([0-9-]*)', function ($id){
        $um = new UserModel();
        $data = $um->getUserByDepId($id);
        echo json_encode($data);
    }, 'get');

    Route::add('/updateTask', function (){
        $json = json_decode(file_get_contents("php://input"), true);
        $tm = new TasksModel();

        $tm->updateTask($json);

    }, 'post');


} else{
    http_send_status(401);
}















