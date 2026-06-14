<?php

class DB {
    private $host = "localhost";
    private $dbname = "carvows";
    private $username = "root";
    private $password = "";
    private $conn;

    public function connect() {
        $this->conn = null;

        try {
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->dbname . ";charset=utf8mb4";
            
            $this->conn = new PDO($dsn, $this->username, $this->password);

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            
        } catch(PDOException $e) {
            echo "Erro na conexão com o banco de dados: " . $e->getMessage();
            die();
        }

        return $this->conn;
    }
}