<?php
require __DIR__ . '/vendor/autoload.php';


// Use this namespace
use Steampixel\Route;

Route::add('/', function() {
    $pager = new App\generatePage();
    echo $pager->buildPage("auth.php");
}, 'get');

Route::add('/auth', function() {

}, 'get');

Route::run('/');