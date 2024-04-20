<?php
// Массив маршрутов и соответствующих им действий контроллеров
$routes = [
    '/register' => 'UserController@registerAction',       // Регистрация пользователя
    '/login' => 'UserController@loginAction',             // Авторизация пользователя
    '/logout' => 'UserController@logoutAction',           // Выход пользователя
    '/user' => 'UserController@getAuthUserAction',        // Получение авторизованного пользователя
    '/orders' => 'OrdersController@getListAction',        // Получение списка заказов
    '/order' => 'OrdersController@getOrderAction',        // Получение информации о заказе
    '/order/update' => 'OrdersController@updateAction',   // Обновление информации о заказе
    '/order/delete' => 'OrdersController@deleteAction',   // Удаление заказа
    '/order/create' => 'OrdersController@createAction',   // Создание нового заказа
];

$request_uri = $_SERVER['REQUEST_URI'];

// Проверяем, есть ли запрошенный маршрут в массиве маршрутов
if (array_key_exists($request_uri, $routes)) {
    $handler = $routes[$request_uri];

    // Разбиваем строку вида "Controller@method" на имя контроллера и метод
    list($controller_name, $method) = explode('@', $handler);

    // Подключаем файл контроллера
    require_once 'Controllers/' . $controller_name . '.php';

    // Создаем экземпляр контроллера
    $controller = new $controller_name();

    // Вызываем метод контроллера
    $controller->$method();
} else {
    // Возвращаем ошибку 404, если маршрут не найден
    echo "404 - Страница не найдена";
}
