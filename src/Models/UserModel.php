<?php

namespace App\Models;

use Exception;
use Jenssegers\Blade\Blade;
use  \RedBeanPHP as rb;

class UserModel
{

    public function getUser($login, $pass)//
    {
         return rb\R::findOne('users', 'login = ? AND pass = ? ', [$login, $pass]);
    }

    public function getAllusers() {//
        return rb\R::findAll('users');
    }

    public function getUserById($id) {//


        return rb\R::findOne('users', 'id = ?', [$id]);
    }

    public function getUserByDepId($id) {
        return json_encode(rb\R::findAll('users', 'department = ?', [$id]));
    }
    
}