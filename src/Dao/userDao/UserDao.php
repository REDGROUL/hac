<?php

namespace App\Dao\userDao;
use App\Model\User;

interface UserDao
{
    function findUserById($id);
    function findUserByLoginAndPassword(User $user);
    function setNewUser(User $user);
    function getAllUsers();
    function getUserByDepId($id);
}