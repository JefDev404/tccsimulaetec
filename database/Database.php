<?php
class Database {
    
    private $host = 'localhost';
    private $user = 'root';
    private $password = "usbw";
    private $dbname = "simulaetec_db";
    public $conn;

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->dbname);

        if ($this->conn->connect_error) {
            die("Conexão falhou: " . $this->conn->connect_error);
        }
    }

    public function close() {
        $this->conn->close();
    }
    
}