<?php
namespace App\Controllers;

use App\Models\UserModel as um;


class UserController
{
    public function login($post_data)
    {
        if(!empty($post_data['login']) and !empty($post_data['pass']))
        {
            $um = new um();

            $res = $um->getUser($post_data['login'], $post_data['pass']);

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