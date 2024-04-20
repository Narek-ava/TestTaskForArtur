<?php

class DB {
    private $servername; // Имя сервера базы данных
    private $username;   // Имя пользователя базы данных
    private $password;   // Пароль пользователя базы данных
    private $dbname;     // Имя базы данных
    private $conn;       // Объект соединения с базой данных

    public function __construct($servername, $username, $password, $dbname) {
        $this->servername = $servername; // Устанавливаем имя сервера
        $this->username = $username;     // Устанавливаем имя пользователя
        $this->password = $password;     // Устанавливаем пароль
        $this->dbname = $dbname;         // Устанавливаем имя базы данных
    }

    // Метод для установления соединения с базой данных
    public function connect() {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        if ($this->conn->connect_error) {
            die("Ошибка соединения: " . $this->conn->connect_error);
        }
    }

    // Метод для закрытия соединения с базой данных
    public function close() {
        $this->conn->close();
    }

    // Метод для получения объекта соединения с базой данных
    public function getConnection() {
        return $this->conn;
    }
}
