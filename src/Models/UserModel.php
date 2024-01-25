<?php

namespace App\Models;
use  \RedBeanPHP as rb;

class UserModel
{
    public function addUser($login, $pass, $name, $role, $dep)
    {
        $userDb = rb\R::dispense('users');
        $userDb->login = $login;
        $userDb->pass = $pass;
        $userDb->name = $name;
        $userDb->role = $role;
        $userDb->department = $dep;

        try{
            rb\R::store($userDb);
            echo json_encode(['status'=>"ok"]);

        } catch (\Exception $e) {
            echo json_encode(['status'=>"bad"]);
        }

    }

    

    /**
     * @return rb\OODBBean|rb\OODBBean[]
     */
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
        return rb\R::findAll('users', 'department = ?', [$id]);
    }



}