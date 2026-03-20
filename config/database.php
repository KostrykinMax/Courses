<?php
class Database {
    private $host = 'localhost';
    private $user = 'root';
    private $pass = '';
    private $name = 'coursesdb';
    private $conn;

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        try {
            $this->conn = mysqli_connect($this->host, $this->user, $this->pass, $this->name);
            mysqli_set_charset($this->conn, 'utf8mb4');
            
            if (!$this->conn) {
                throw new Exception("Connection failed: " . mysqli_connect_error());
            }
        } catch (Exception $e) {
            die("Ошибка подключения к БД: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->conn;
    }

    public function query($sql) {
        $result = mysqli_query($this->conn, $sql);
        if (!$result) {
            throw new Exception("Ошибка запроса: " . mysqli_error($this->conn));
        }
        return $result;
    }

    public function escape($value) {
        return mysqli_real_escape_string($this->conn, $value);
    }

    public function lastInsertId() {
        return mysqli_insert_id($this->conn);
    }

    public function fetchAll($result) {
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        return $data;
    }

    public function fetchOne($result) {
        return mysqli_fetch_assoc($result);
    }
}