<?php
require __DIR__ . '/vendor/autoload.php';


use Steampixel\Route;


Route::add('/', function() {
    $blade = new Jenssegers\Blade\Blade('src/views','src/cache');
    echo $blade->make('auth',['title'=>'Авторизация', 'navbar_show'=>false])->render();
}, 'get');

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

Route::add('/main', function (){
    $blade = new Jenssegers\Blade\Blade('src/views','src/cache');
    echo $blade->make('main', ['navbar_show'=>true])->render();
}, 'get');


Route::add('/course/33', function () {
    $blade = new Jenssegers\Blade\Blade('src/views','src/cache');
    echo $blade->make('course', ['navbar_show'=>true])->render();
},'get');

Route::add('/tasks', function (){
    $blade = new Jenssegers\Blade\Blade('src/views','src/cache');

    $taskModel = new \App\Models\TasksModel();
    $boards = $taskModel->getAllBoard();
    $tasks = $taskModel->getAllTasks();
    echo $blade->make('tasks', ['navbar_show'=>true, 'boards'=>$boards, 'tasks'=>$tasks])->render();
});


Route::add('/tasks/changeStatus', function (){
    $json = json_decode(file_get_contents("php://input"), true);
    if(!empty($json) && $json['type'] == 'changeStatus')
    {
        $tc = new \App\Controllers\TaskController();
        $tc->changeStatus($json);
    }
}, 'post');







Route::run('/');