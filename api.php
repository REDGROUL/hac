<?php

use App\Controllers\BoardsController;
use App\Controllers\CommentController;
use App\Controllers\DepartmentController;
use App\Controllers\TaskController;
use App\Controllers\UserController;
use App\Security\SimpleSecurity;
use Steampixel\Route;
if(isset($_SESSION['auth'])) {

    Route::add('/tasks/changeStatus', fn()=>(new TaskController())->changeStatus(), 'post');

    Route::add('/tasks/newTasks', fn()=>(new TaskController())->newTask());

    Route::add('/addNewComment', fn()=>(new CommentController())->addNewComment(), 'post');

    Route::add('/addBoard', fn()=>(new BoardsController())->addBoard(), 'post');

    Route::add('/delboard', fn()=>(new BoardsController())->delBoard(), 'post');

    Route::add('/delTask/([0-9-]*)', fn($id)=>(new TaskController())->delTaskById($id), 'post');

    Route::add('/addUser',fn()=>(new UserController())->addUser(), 'post');

    Route::add('/addDep',fn()=>(new DepartmentController())->createDep(), 'post');

    Route::add('/getUserByDep/([0-9-]*)',fn($id)=>(new UserController())->getUserByDepId($id));

    Route::add('/updateTask',fn()=>(new TaskController())->updateTask(), 'post');

} else{
    Route::add('/auth', fn()=>(new SimpleSecurity())->auth(), 'post');

}


