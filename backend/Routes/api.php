<?php
$routes = [
    '/register' => 'UserController@registerAction',
    '/login' => 'UserController@loginAction',
    '/logout' => 'UserController@logoutAction',
    '/user' => 'UserController@getAuthUserAction',
    '/orders' => 'OrdersController@getListAction',
    '/order' => 'OrdersController@getOrderAction',
    '/order/update' => 'OrdersController@updateAction',
    '/order/delete' => 'OrdersController@deleteAction',
    '/order/create' => 'OrdersController@createAction',
];

$request_uri = $_SERVER['REQUEST_URI'];

if (array_key_exists($request_uri, $routes)) {
    $handler = $routes[$request_uri];

    list($controller_name, $method) = explode('@', $handler);

    require_once 'Controllers/' . $controller_name . '.php';

    $controller = new $controller_name();

    $controller->$method();
} else {
    echo "404 - Page not found";
}
