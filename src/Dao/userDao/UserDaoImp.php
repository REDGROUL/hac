<?php

namespace App\Dao\userDao;

use App\Model\User;
use  \RedBeanPHP as rb;

class UserDaoImp implements UserDao
{

    function findUserById($id): ?rb\OODBBean
    {
        return rb\R::findOne('users', 'id = ?', [$id]);
    }

    function findUserByLoginAndPassword(User $user): ?rb\OODBBean
    {
        return rb\R::findOne('users', 'login = ? AND password = ?', [$user->getLogin(), $user->getPassword()]);
    }

    function setNewUser(User $user): bool
    {
        $userDb = rb\R::dispense('users');
        $userDb->login = $user->getLogin();
        $userDb->pass = $user->getPassword();
        $userDb->name = $user->getName();
        $userDb->role = $user->getRole();
        $userDb->department = $user->getDepartment();

        try{
            rb\R::store($userDb);
            return true;
        }  catch (rb\RedException\SQL $e) {
            return false;
        }
    }

    function getAllUsers(): array
    {
        return rb\R::findAll('users');
    }

    function getUserByDepId($id): array
    {
        return rb\R::findAll('users', 'department = ?', [$id]);
    }
}