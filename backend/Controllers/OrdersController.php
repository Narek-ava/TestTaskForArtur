<?php
include('Controllers/Controller.php'); // Подключение базового контроллера
include('Services/UserServices/UserService.php'); // Подключение сервиса пользователей
include('Services/CRMServices/CRMServices.php'); // Подключение сервиса для работы с заказами

class OrdersController
{
    // Конструктор класса
    public function __construct()
    {
        global $db;
        $this->db = $db; // Инициализация объекта базы данных
    }

    // Метод для обработки запроса на получение списка заказов пользователя
    public function getListAction(){
        $request = json_decode(file_get_contents('php://input'), true); // Получение данных запроса
        $__token = $request['token']; // Токен пользователя

        $orders = new CRMServices( $this->db->getConnection()); // Создание объекта CRMServices

        return $orders->getUserOrders($__token); // Вызов метода для получения списка заказов пользователя
    }

    // Метод для обработки запроса на получение информации о заказе
    public function getOrderAction(){
        $request = json_decode(file_get_contents('php://input'), true); // Получение данных запроса
        $__id = $request['id']; // ID заказа

        $order = new CRMServices( $this->db->getConnection()); // Создание объекта CRMServices

        return $order->getOrder($__id); // Вызов метода для получения информации о заказе
    }

    // Метод для обновления информации о заказе
    public function updateAction()
    {
        $request = json_decode(file_get_contents("php://input"), true); // Получение данных запроса
        $order_id = $request['ID']; // ID заказа
        $detail = $request['detail']; // Детали заказа
        $status = $request['status']; // Статус заказа

        $order = new CRMServices( $this->db->getConnection()); // Создание объекта CRMServices

        return $order->updateOrder($detail, $status, $order_id); // Вызов метода для обновления информации о заказе
    }

    // Метод для удаления заказа
    public function deleteAction(){
        $request = json_decode(file_get_contents("php://input"), true); // Получение данных запроса
        $order_id = $request['order_id']; // ID заказа

        $order = new CRMServices( $this->db->getConnection()); // Создание объекта CRMServices

        return $order->deleteOrder($order_id); // Вызов метода для удаления заказа
    }

    // Метод для создания нового заказа
    public function createAction()
    {
        $request = json_decode(file_get_contents('php://input'), true); // Получение данных запроса
        $detail = $request['detail']; // Детали заказа
        $status = $request['status']; // Статус заказа
        $token = $request['token']; // Токен пользователя

        $order = new CRMServices( $this->db->getConnection()); // Создание объекта CRMServices

        return $order->createOrder( $detail, $status,$token); // Вызов метода для создания нового заказа
    }
}
