<?php

use App\Controllers\DepartmentController;
use App\Controllers\KanbanController;
use App\Controllers\UserController;
use Steampixel\Route;
use App\Controllers\TaskController;
session_start();

if(isset($_SESSION['auth'])) {

    Route::add('/tasks', fn()=>(new TaskController())->getPrepareTasks());

    Route::add('/task/([0-9-]*)', fn($id)=>(new TaskController())->getDetailTask($id));

    Route::add('/ref', fn()=>(new KanbanController())->getPrepareRefs());

    Route::add('/profile/([0-9-]*)', fn($id)=>(new UserController())->getDataProfile($id));

    Route::add('/deps', fn()=>(new DepartmentController())->getAllDepartments());

    Route::add('/newUser', fn() => (new UserController())->getPrepareNewUser());

    Route::add('/tasks/([0-9-]*)', fn($id)=>(new TaskController())->getPrepareKanbanById($id));

    Route::add('/logout', function (){
        unset($_SESSION['auth']);
        header('Location: /');
    });

} else {
    Route::add('/',fn()=>(new UserController())->getPrepareLogin());
}
