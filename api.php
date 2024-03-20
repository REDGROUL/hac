<?php

use App\Controllers\BoardsController;
use App\Controllers\CommentController;
use App\Controllers\DepartmentController;
use App\Controllers\TaskController;
use App\Controllers\UserController;
use Steampixel\Route;

if(isset($_SESSION['auth'])) {

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
        $um = new DepartmentController();
        echo $um->getUserByDepId($id);
    }, 'get');

    Route::add('/updateTask', function (){
        $tm = new TaskController();
        echo $tm->updateTask();
    }, 'post');


} else{
    Route::add('/login', function (){
        $uc = new UserController();
        echo $uc->login();
    }, 'post');
}















