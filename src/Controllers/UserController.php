<?php
namespace App\Controllers;

use App\Model\User;
use App\Models\UserModel;
use App\Models\TasksModel;
use App\Service\Impl\UserServiceImpl;
use App\Service\Interfaces\UserService;
use Firebase\JWT\JWT;
use Jenssegers\Blade\Blade;
use mysql_xdevapi\Exception;

class UserController extends BaseController
{

    private TasksModel $taskMode;
    private Blade $blade;
    private UserService $userService;
    function __construct()
    {
        $this->userService = new UserServiceImpl();

        $this->taskMode = new TasksModel();

        $this->blade = new Blade('src/views','src/cache');
    }


    public function addUser() {
        $data = $this->getInput();
        $user = new User();
        $user->setLogin($data['login']);
        $user->setPassword($data['pass']);
        $user->setName($data['name']);
        $user->setRole($data['role']);
        $user->setDepartment($data['dep']);

        return json_encode(["status"=>$this->userService->setNewUser($user)]);

    }

    public function getUserByDepId($id) {
        return $this->userService->findUserByDepartmentId($id);
    }

    public function getDataProfile($id) {
        $currentUser = $this->userService->getUserById($id);
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