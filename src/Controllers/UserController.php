<?php
namespace App\Controllers;

use App\Models\UserModel;
use App\Models\UserModel as um;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


class UserController extends BaseController
{

    private UserModel $userModel;

    function __construct()
    {
        $this->userModel = new UserModel();
    }


    public function login()
    {
        $json = $this->getInput();
        $um = new um();

        $res = $um->getUser($json['login'], $json['pass']);

        if(!empty($res))
        {

            $key = "some_keyhehe";
            $time = time();
            $access = [
                'iat' => $time,
                'exp' => time()+36000,
                'login'=>$res['login'],
                'name'=>$res['name'],
                'type'=>'access',
                'user_id'=>$res['id'],
                'role'=>$res['role']

            ];
            $ref = [
                'type'=>'refresh',
                'user_id'=>$res['id']
            ];
            $token_acc = JWT::encode($access, $key, 'HS256');
            $token_ref = JWT::encode($ref, $key, 'HS256');
            session_start();
            $_SESSION['uid'] = $res['id'];
            $_SESSION['role'] = $res['role'];
            $_SESSION['auth'] = true;
            $_SESSION['dep'] = $res['department'];

            return json_encode([
                "status"=>"ok",
                'access'=>$token_acc,
                'refresh'=>$token_ref
            ]);

        }
        else
        {
            return json_encode([
                "status"=>"user not found"
            ]);
        }

    }
}