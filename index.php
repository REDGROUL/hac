<?php
require __DIR__ . '/vendor/autoload.php';



// Use this namespace
use Steampixel\Route;

Route::add('/', function() {
    $blade = new Jenssegers\Blade\Blade('src/views','src/cache');
    echo $blade->make('auth',['title'=>'Авторизация'])->render();
}, 'get');

Route::add('/login', function (){
//    $uc = new \App\Controllers\UserController();
//    $uc->login($_POST);
    $input = json_decode(file_get_contents("php://input"), true);
    var_dump($input);
}, 'post');

Route::run('/');