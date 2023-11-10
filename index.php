<?php
require __DIR__ . '/vendor/autoload.php';



// Use this namespace
use Steampixel\Route;

Route::add('/', function() {
    $blade = new Jenssegers\Blade\Blade('src/views','src/cache');
    echo $blade->make('auth',['title'=>'Авторизация'])->render();
}, 'get');

Route::add('/login', function (){


    $json = json_decode(file_get_contents("php://input"), true);
    if($json['type'] == 'auth')
    {
        $uc = new \App\Controllers\UserController();
        $uc->login($json);
    }




}, 'post');

Route::run('/');