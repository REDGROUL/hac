<?php


namespace App\Security;


use App\Model\User;
use App\Service\Impl\UserServiceImpl;
use App\Service\Interfaces\UserService;

class SimpleSecurity implements Auth
{
    private UserService $userService;

    public function __construct()
    {
        $this->userService = new UserServiceImpl();
    }

    public function auth()
    {
        $loginAndPass = json_decode(file_get_contents("php://input"), true);

        if (!isset($loginAndPass['login']) && isset($loginAndPass['pass'])) {
            return false;
        }
        $user = new User();
        $user->setLogin($loginAndPass['login']);
        $user->setPassword($loginAndPass['pass']);
        $AuthUser = $this->userService->findUserByLoginAndPassword($user);


        if (!$AuthUser) {
            return false;
        }
        session_start();
        $_SESSION['auth'] = true;
        $_SESSION['uid'] = $AuthUser['id'];
        $_SESSION['role'] = $AuthUser['role'];
        $_SESSION['name'] = $AuthUser['name'];
        $_SESSION['photo'] = $AuthUser['photo'];
        $_SESSION['dep'] = $AuthUser['department'];

        $user->setName($AuthUser['name']);
        $user->setDepartment($AuthUser['department']);
        $user->setRole($AuthUser['role']);


        $user->setDepartment((int)$AuthUser['dep']);

        return json_encode([
            "status" => true,
            "uid" => $AuthUser['id'],
        ]);

    }

    function logout()
    {
        session_destroy();
    }

    public static function getAuthUser()
    {
        $AuthUser = new User();
        $AuthUser->setId((int)$_SESSION['uid']);
        $AuthUser->setName((int)$_SESSION['role']);
        $AuthUser->setName($_SESSION['name']);
        $AuthUser->setPhoto((string)$_SESSION['photo']);
        $AuthUser->setDepartment((int)$_SESSION['dep']);
        return $AuthUser;
    }
}