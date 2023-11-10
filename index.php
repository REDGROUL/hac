<?php
require __DIR__ . '/vendor/autoload.php';
// Use this namespace
use Steampixel\Route;

Route::add('/', function() {
    echo 'Welcome :-)';
}, 'get');

Route::add('/auth', function() {

}, 'get');

Route::run('/');