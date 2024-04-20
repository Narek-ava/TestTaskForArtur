<?php
$servername = "localhost"; // Имя сервера базы данных
$username = "user"; // Имя пользователя базы данных
$DBpassword = "password"; // Пароль пользователя базы данных
$dbname = "api"; // Имя базы данных

// Установка заголовков для CORS (Cross-Origin Resource Sharing)
header("Access-Control-Allow-Origin: *"); // Разрешить доступ с любого источника
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT"); // Разрешенные HTTP методы
header("Access-Control-Allow-Headers: Content-Type"); // Разрешенные заголовки запроса

// Проверка, является ли запрос OPTIONS, и если да, отправляем успешный ответ
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200); // Ответ 200 OK
    exit(); // Завершаем выполнение скрипта
}
