<?php
// Подключаем переменные для соединения с базой данных
global $servername, $username, $DBpassword, $dbname, $db;
include('DB/DBconnections/DBconnections.php'); // Подключаем файл с настройками подключения к базе данных
include('Routes/api.php'); // Подключаем файл с маршрутами API
