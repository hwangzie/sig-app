<?php
/**
 * Database Configuration
 * Sistem Informasi Geospatial - Tugas Mata Kuliah
 */

class Database {
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "sig_app";
    private $connection;

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        try {
            $this->connection = new mysqli(
                $this->host, 
                $this->username, 
                $this->password, 
                $this->database
            );
            
            if ($this->connection->connect_error) {
                throw new Exception("Connection failed: " . $this->connection->connect_error);
            }
            
            // Set charset to UTF-8
            $this->connection->set_charset("utf8");
            
        } catch (Exception $e) {
            die("Database connection error: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->connection;
    }

    public function close() {
        if ($this->connection) {
            $this->connection->close();
        }
    }
}

// Legacy support - untuk backward compatibility dengan file lama
$db = new Database();
$conn = $db->getConnection();
?>