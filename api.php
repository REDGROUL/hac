<?php

use App\Controllers\BoardsController;
use App\Controllers\CommentController;
use App\Controllers\DepartmentController;
use App\Controllers\TaskController;
use App\Controllers\UserController;
use Steampixel\Route;
Route::add('/tasks/([0-9-]*)', fn($id)=>(new TaskController())->getTask($id));
if(isset($_SESSION['auth'])) {

    Route::add('/tasks/changeStatus', fn()=>(new TaskController())->changeStatus(), 'post');

    Route::add('/tasks/newTasks', fn()=>(new TaskController())->newTask());

    Route::add('/addNewComment', fn()=>(new CommentController())->addNewComment(), 'post');

    Route::add('/addBoard', fn()=>(new BoardsController())->addBoard(), 'post');

    Route::add('/delboard', fn()=>(new BoardsController())->delBoard(), 'post');

    Route::add('/delTask/([0-9-]*)', fn($id)=>(new TaskController())->delTaskById($id), 'post');

    Route::add('/addUser',fn()=>(new UserController())->addUser(), 'post');

    Route::add('/addDep',fn()=>(new DepartmentController())->createDep(), 'post');

    Route::add('/getUserByDep/([0-9-]*)',fn($id)=>(new DepartmentController())->getDepartmentNameById($id));

    Route::add('/updateTask',fn()=>(new TaskController())->updateTask(), 'post');

} else{
    Route::add('/login', fn()=>(new UserController())->login(), 'post');
}
