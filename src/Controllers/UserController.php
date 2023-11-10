<?php
namespace App\Controllers;

use App\Models\UserModel as um;


class UserController
{
    public function login($json)
    {

        if(!empty($json))
        {
            $um = new um();

            $res = $um->getUser($json['login'], $json['pass']);

            if(!empty($res))
            {
                echo json_encode([
                    "status"=> 'ok',
                    'payload'=>[
                        'login'=>$res->login,
                        'name'=>$res->name
                    ]
                ]);
            }
            else
            {
                echo 'ne zbs';
            }
        }
    }
}