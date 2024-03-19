<?php


namespace App\Controllers;


class BaseController
{
    public function getInput() {
        return json_decode(file_get_contents("php://input"), true);
    }
}