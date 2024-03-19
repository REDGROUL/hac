<?php

use App\Controllers\BoardsController;
use App\Controllers\CommentController;
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
    $json = json_decode(file_get_contents("php://input"), true);
    $um = new UserModel();
    $um->addUser($json['login'], $json['pass'], $json['name'], $json['role'], $json['dep']);


}, 'post');

Route::add('/addDep', function (){
    $json = json_decode(file_get_contents("php://input"), true);
    $dm = new DepartmentModel();
    $dm->createDep($json);
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