<?php


namespace App\Security;


interface Auth
{
    function auth();
    function logout();
    static function getAuthUser();
}