<?php
include('Services/UserServices/UserService.php'); // Подключение класса UserService
include('Controllers/Controller.php'); // Подключение базового контроллера

class UserController
{

    public function __construct()
    {
        global $db;
        $this->db = $db; // Инициализация объекта базы данных
    }

    // Метод для обработки запроса на регистрацию пользователя
    public function registerAction()
    {
        $request = json_decode(file_get_contents('php://input'), true); // Получение данных запроса
        $__userName = $request['name']; // Имя пользователя
        $__password = $request['password']; // Пароль пользователя
        $__email = $request['email']; // Email пользователя

        $user = new UserService($this->db->getConnection()); // Создание объекта UserService

        return $user->register($__userName, $__password , $__email); // Вызов метода регистрации пользователя
    }

    // Метод для обработки запроса на вход пользователя
    public function loginAction()
    {
        $request = json_decode(file_get_contents('php://input'), true); // Получение данных запроса
        $__password = $request['password']; // Пароль пользователя
        $__email = $request['email']; // Email пользователя

        $user = new UserService($this->db->getConnection()); // Создание объекта UserService

        $user->login($__email,$__password); // Вызов метода входа пользователя
    }

    // Метод для обработки запроса на выход пользователя
    public function logoutAction()
    {
        $user = new UserService($this->db->getConnection()); // Создание объекта UserService

        $user->logout(); // Вызов метода выхода пользователя
    }

    // Метод для получения данных авторизованного пользователя
    public function getAuthUserAction()
    {
        $request = json_decode(file_get_contents('php://input'), true); // Получение данных запроса
        $__token = $request['token']; // Токен пользователя

        $user = new UserService($this->db->getConnection()); // Создание объекта UserService

        return $user->getAuthUser($__token); // Вызов метода получения данных авторизованного пользователя
    }
}
