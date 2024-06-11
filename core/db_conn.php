<?php

class Database {
    private static $instance;
    private $connection;
    private $hostname;
    private $username;
    private $password;
    private $database;

    private function __construct() {
        $this->hostname = '31.31.198.18';
        $this->username = 'u0881075_stud2';
        $this->password = 'Vkrb2024@';
        $this->database = 'u0881075_helptm';

        $this->connection = new mysqli($this->hostname, $this->username, $this->password, $this->database);
        if ($this->connection->connect_error) {
            die('Ошибка подключения (' . $this->connection->connect_errno . ') ' . $this->connection->connect_error);
        }
        $this->connection->set_charset("utf8");
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }
}
