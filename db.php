<?php

class Database {
    private $host = "127.0.0.1";
    private $username = "root";
    private $password = "password";
    private $dbname = "test_db";
    protected $conn;
    public function __construct() {
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
          die("Connection failed: " . $e->getMessage());
        }
    }
}