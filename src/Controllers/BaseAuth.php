<?php


namespace App\Controllers;


class BaseAuth extends BaseController implements Auth
{

    function auth()
    {
        $json = $this->getInput();
        $res = $this->userModel->getUser($json['login'], $json['pass']);
    }

    function logout()
    {
        // TODO: Implement logout() method.
    }

    function checkAuth() {

    }
}