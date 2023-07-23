<?php

class Database {

    private $connection;

        public function __construct() {
            $this->host = 'localhost';
            $this->username = 'root';
            $this->password = '';
            $this->database = 'narayan';
    
            $this->connect();
        }
    
        private function connect() {
            try {
                $this->connection = new PDO("mysql:host=$this->host;dbname=$this->database", $this->username, $this->password);
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Connection failed: " . $e->getMessage());
            }
        }
    
        public function Connection() {
            return $this->connection;
        }
  }

?>