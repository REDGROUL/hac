<?php
require __DIR__ . '/vendor/autoload.php';



// Use this namespace
use Steampixel\Route;

Route::add('/', function() {
    $blade = new Jenssegers\Blade\Blade('src/views','src/cache');
    echo $blade->make('auth',['title'=>'Авторизация'])->render();
}, 'get');


Route::run('/');