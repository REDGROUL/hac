<?php


namespace App\abstracts;


interface Auth
{
    function auth();

    function logout();
}