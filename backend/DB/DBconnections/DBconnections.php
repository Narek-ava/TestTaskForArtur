<?php
include("DB/Configs/config.php"); // Подключение файла с конфигурацией базы данных
include('DB/Models/DB.php'); // Подключение класса для работы с базой данных

global $servername, $username, $DBpassword, $dbname; // Объявление глобальных переменных для данных подключения к БД

// Создание экземпляра класса для работы с базой данных и передача ему параметров подключения
$db = new DB($servername, $username, $DBpassword, $dbname);

// Установка соединения с базой данных
$db->connect();