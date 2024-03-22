<?php

namespace App\Service\Interfaces;

use App\Model\User;

interface UserService
{
    function findUserById(int $id);
    function findUserByLoginAndPassword(User $user);
    function findAllUsersByDepartmentId(int $id);
    function setNewUser(User $user);
}