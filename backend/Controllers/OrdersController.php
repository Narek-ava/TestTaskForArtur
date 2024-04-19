<?php
include('Controllers/Controller.php');
include('Services/UserServices/UserService.php');
include('Services/CRMServices/CRMServices.php');

class OrdersController
{
    public function __construct()
    {
        global $db;
        $this->db = $db;
    }
    public function getListAction(){
        $request = json_decode(file_get_contents('php://input'), true);//todo  перенести в отдельный класс request
        $__token = $request['token'];
        $orders = new CRMServices( $this->db->getConnection());

        return $orders->getUserOrders($__token);
    }

    public function getOrderAction(){
        $request = json_decode(file_get_contents('php://input'), true);//todo  перенести в отдельный класс request
        $__id = $request['id'];
        $order = new CRMServices( $this->db->getConnection());

        return $order->getOrder($__id);
    }

    public function updateAction()
    {
        $request = json_decode(file_get_contents("php://input"), true);
        $order_id = $request['ID'];
        $detail = $request['detail'];
        $status = $request['status'];

        $order = new CRMServices( $this->db->getConnection());

        return $order->updateOrder($detail, $status, $order_id);
    }

    public function deleteAction(){
        $request = json_decode(file_get_contents("php://input"), true);
        $order_id = $request['order_id'];

        $order = new CRMServices( $this->db->getConnection());

        return $order->deleteOrder($order_id);
    }

    public function createAction()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        $detail = $request['detail'];
        $status = $request['status'];
        $token = $request['token'];

        $order = new CRMServices( $this->db->getConnection());

        return $order->createOrder( $detail, $status,$token);
    }
}