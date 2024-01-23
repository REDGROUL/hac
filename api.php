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
//    $json = file_get_contents("php://input");
//    echo json_encode($json);




    $tc = new \App\Controllers\TaskController();

    echo json_encode($_FILES);
    if(($_FILES['file']['size'] > 0)) {
        $uploaddir = 'res/images/';
        $uploadfile = $uploaddir . basename($_FILES['file']['name']);


        if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
            $_POST['photo'] = $uploadfile;

            $tc->newTask($_POST);
        }
    } else {
        $_POST['photo'] = "res/images/noimage.jpg";
        $tc->newTask($_POST);
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

Route::add('/addUser', function (){
    $json = json_decode(file_get_contents("php://input"), true);
    $um = new \App\Models\UserModel();

    $um->addUser($json['login'], $json['pass'], $json['name'], $json['role'], $json['dep']);


}, 'post');

Route::add('/addDep', function (){
    $json = json_decode(file_get_contents("php://input"), true);
    $dm = new \App\Models\DepartmentModel();
    $dm->createDep($json);
}, 'post');

Route::add('/getUserByDep/([0-9-]*)', function ($id){
    $um = new \App\Models\UserModel();
    $data = $um->getUserByDepId($id);
    echo json_encode($data);
}, 'get');

Route::add('/updateTask', function (){
    $json = json_decode(file_get_contents("php://input"), true);
    $tm = new \App\Models\TasksModel();


    $tm->updateTask($json);

}, 'post');