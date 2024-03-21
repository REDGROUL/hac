<?php

namespace App\Models;
use Jenssegers\Blade\Blade;
use  \RedBeanPHP as rb;

class UserModel
{

    private Blade $blade;

    public function __construct()
    {
        $this->blade = new Blade('src/views','src/cache');
    }

    public function addUser($data)
    {
        $userDb = rb\R::dispense('users');
        $userDb->login = $data['login'];
        $userDb->pass = $data['password'];
        $userDb->name = $data['name'];
        $userDb->role = $data['role'];
        $userDb->department = $data['dep'];

        try{
            rb\R::store($userDb);
            return json_encode(['status'=>"ok"]);

        } catch (\Exception $e) {
            return json_encode(['status'=>"bad"]);
        }

    }
    public function getUser($login, $pass)
    {
         return rb\R::findOne('users', 'login = ? AND pass = ? ', [$login, $pass]);
    }

    public function getAllusers() {
        return rb\R::findAll('users');
    }

    public function getUserById($id) {
        return rb\R::findOne('users', 'id = ?', [$id]);
    }

    public function getUserByDepId($id) {
        return json_encode(rb\R::findAll('users', 'department = ?', [$id]));
    }
    
}