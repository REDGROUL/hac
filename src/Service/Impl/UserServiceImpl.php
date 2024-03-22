<?php

namespace App\Service\Impl;

use App\Dao\userDao\UserDao;
use App\Dao\userDao\UserDaoImp;
use App\Model\User;
use App\Service\Interfaces\UserService;

class UserServiceImpl implements UserService
{

    private UserDao $userDao;

    public function __construct()
    {
        $this->userDao = new UserDaoImp();
    }

    function findAllUser() {
        return $this->userDao->findAllUsers();
    }

    function findUserById(int $id)
    {
       return $this->userDao->findUserById($id);
    }

    function findUserByLoginAndPassword(User $user)
    {
        return $this->userDao->findUserByLoginAndPassword($user);
    }

    function findAllUsersByDepartmentId(int $id)
    {
        return $this->userDao->getUserByDepId($id);
    }

    function setNewUser(User $user)
    {
        return $this->userDao->setNewUser($user);
    }

    function findUserByDepartmentId($id) {
        return $this->userDao->getUserByDepId($id);
    }
}