<?php
require __DIR__ . '/vendor/autoload.php';


use Steampixel\Route;
use  RedBeanPHP as rb;
rb\R::setup( 'mysql:host=localhost;dbname=kittyFrame','root', '' );

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




Route::add('/tasks', function (){
    $blade = new Jenssegers\Blade\Blade('src/views','src/cache');

    $taskModel = new \App\Models\TasksModel();
    $boards = $taskModel->getAllBoard();
    $tasks = $taskModel->getAllTasks();
    $um = new \App\Models\UserModel();
    $users = $um->getAllusers();
    echo $blade->make('tasks', ['navbar_show'=>true, 'boards'=>$boards, 'tasks'=>$tasks, 'users'=>$users])->render();
});


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


Route::add('/task/([0-9-]*)', function ($id) {

    $tm = new \App\Models\TasksModel();
    $data = $tm->getTaskById($id);

    $cm = new \App\Models\CommentsModel();
    $comments = $cm->getCommentsByTaskId($id);

    $um = new \App\Models\UserModel();
    $userDataForComments = [];
    foreach ($comments as $comment) {


        $comment['user_data'] = $um->getUserById($comment['user_id']);
    }




    $blade = new Jenssegers\Blade\Blade('src/views','src/cache');
    echo $blade->make('taskDetail', ['navbar_show'=>true, 'currentTask'=>$data, 'comments'=>$comments])->render();
},'get');





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

Route::add('/profile/([0-9-]*)', function ($id){
    $um = new \App\Models\UserModel();
    $currentUser = $um->getUserById($id);

    $tm = new \App\Models\TasksModel();
    $tasks = $tm->getTaskByUserId($id);

    $blade = new Jenssegers\Blade\Blade('src/views','src/cache');
    echo $blade->make('profile', ['navbar_show'=>true, 'userData'=>$currentUser, 'tasks'=>$tasks])->render();
});

Route::add('/ref', function (){
    $km = new \App\Models\kanbanModel();
    $kanbanList = $km->getAllBoards();

    $blade = new Jenssegers\Blade\Blade('src/views','src/cache');
    echo $blade->make('kanbanRefresh', ['navbar_show'=>true, 'boards'=>$kanbanList])->render();
});

Route::add('/logout', function (){
    $blade = new Jenssegers\Blade\Blade('src/views','src/cache');
    echo $blade->make('profile', ['navbar_show'=>true])->render();
});





Route::run('/');