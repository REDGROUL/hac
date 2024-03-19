<?php
use App\Controllers\TaskController;
use App\Controllers\UserController;
use App\Models\CommentsModel;
use App\Models\DepartmentModel;
use App\Models\kanbanModel;
use App\Models\TasksModel;
use App\Models\UserModel;
use Steampixel\Route;

Route::add('/login', function (){
    $json = json_decode(file_get_contents("php://input"), true);
    $uc = new UserController();
    echo $uc->login($json);
}, 'post');

Route::add('/tasks/changeStatus', function (){
    $json = json_decode(file_get_contents("php://input"), true);
    $tc = new TaskController();
    echo $tc->changeStatus($json);
}, 'post');


Route::add('/tasks/newTask', function (){
    $tc = new TaskController();

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
    $tc = new CommentsModel();
    return $tc->addNewComment($json);
}, 'post');

Route::add('/addBoard', function (){
    $json = json_decode(file_get_contents("php://input"), true);
    if(!empty($json) && $json['type'] == 'addBoard')
    {
        $tc = new kanbanModel();
        $tc->addBoard($json);
    }
}, 'post');

Route::add('/delboard', function (){
    $json = json_decode(file_get_contents("php://input"), true);
    $tc = new kanbanModel();
    $tc->delBoard($json);
}, 'post');

Route::add('/deltask', function (){
    $json = json_decode(file_get_contents("php://input"), true);
    $tc = new TasksModel();
    $tc->delTaskById($json['id']);
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