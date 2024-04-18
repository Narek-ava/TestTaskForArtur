<?php
include('Services/UserServices/UserService.php');
include('Controllers/Controller.php');

class UserController
{

    public function __construct()
    {
        global $db;
        $this->db = $db;
    }

    public function registerAction()
    {
        $request = json_decode(file_get_contents('php://input'), true);//todo  перенести в отдельный класс request
        $__userName = $request['name'];
        $__password = $request['password'];
        $__email = $request['email'];


        $user = new UserService($this->db->getConnection());

        return $user->register($__userName, $__password , $__email);
    }

    public function loginAction()
    {
        $request = json_decode(file_get_contents('php://input'), true);//todo  перенести в отдельный класс request
        $__password = $request['password'];
        $__email = $request['email'];

        $user = new UserService($this->db->getConnection());

        $user->login($__email,$__password);
    }

    public function logoutAction(){

        $user = new UserService($this->db->getConnection());

        $user->logout();

    }

    public function getAuthUserAction()
    {
        $request = json_decode(file_get_contents('php://input'), true);//todo  перенести в отдельный класс request
        $__token = $request['token'];

        $user = new UserService($this->db->getConnection());

        return $user->getAuthUser($__token);
    }


}