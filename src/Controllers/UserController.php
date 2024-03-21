<?php
namespace App\Controllers;

use App\Models\UserModel;
use App\Models\TasksModel;
use Firebase\JWT\JWT;
use Jenssegers\Blade\Blade;


class UserController extends BaseController
{

    private UserModel $userModel;
    private TasksModel $taskMode;
    private Blade $blade;

    function __construct()
    {
        $this->userModel = new UserModel();
        $this->taskMode = new TasksModel();
        $this->blade = new Blade('src/views','src/cache');
    }


    public function login()
    {
        $json = $this->getInput();

        $res = $this->userModel->getUser($json['login'], $json['pass']);

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

    public function addUser() {
        $data = $this->getInput();
        return $this->userModel->addUser($data);
    }

    public function getUserByDepId($id) {
        return $this->userModel->getUserByDepId($id);
    }

    public function getDataProfile($id) {
        $currentUser = $this->userModel->getUserById($id);
        $tasks = $this->taskMode->getTaskByUserId($id);
        return $this->blade->make('profile', ['title'=>'Профиль','navbar_show'=>true, 'userData'=>$currentUser,
            'tasks'=>$tasks])->render();
    }

    public function getPrepareLogin(){
        return $this->blade->make('auth',['title'=>'Авторизация', 'navbar_show'=>false])->render();
    }

    public function getPrepareNewUser(){
        return $this->blade->make('reg', ['title'=>'Регистрация','navbar_show'=>true])->render();
    }
}