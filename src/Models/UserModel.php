<?php

namespace App\Models;
use  \RedBeanPHP as rb;

class UserModel
{

    protected $usersdb;


    public function __construct()
    {

        rb\R::dispense('users');

    }


    public function addUser($login, $pass, $name)
    {
        $this->usersdb->login = $login;
        $this->usersdb->pass = $pass;
        $this->usersdb->name = $name;

        rb\R::store($this->usersdb);

    }

    

    /**
     * @return rb\OODBBean|rb\OODBBean[]
     */
    public function getUser($login, $pass)
    {
         return rb\R::findOne('users', 'login = ? AND pass = ? ', [$login,$pass]);

    }

    public function getAllusers() {
        return rb\R::findAll('users');
    }

    public function getUserById($id) {
        return rb\R::findOne('users', 'id = ?', [$id]);
    }



}