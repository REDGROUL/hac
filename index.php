<?php
require __DIR__ . '/vendor/autoload.php';
require 'routes.php';
require 'api.php';
use  RedBeanPHP as rb;
use Steampixel\Route;


rb\R::setup( 'mysql:host=127.0.0.1;dbname=kittyFrame','root', '' );
Route::run('/');