<?php

class Database {
    private $host;
    private $user;
    private $pass;
    private $db;
    public $conn;

    public function __construct() {
        $this->db_connect();
    }

    private function db_connect() {
        $this->host = 'localhost';
        $this->user = 'root';
        $this->pass = '';
        $this->db = 'employee_system';

        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->db);
        if (!$this->conn) {
            $this->error = "Connection failed" . $this->conn->connect_error;
            return false; 
        }
        return $this->conn;
    }

    public function getEmployees() {
        $allEmp = $this->conn->query("SELECT * FROM employees;");
        return $allEmp;
    }

    public function select($query) {
        $result = $this->conn->query($query) or die($this->conn->error.__LINE__);
        if($result->num_rows > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function insert($query) {
        $insert_result = $this->conn->query($query) or die($this->conn->error.__LINE__);
        if ($insert_result) {
            header("location: index.php");
            exit();
        } else {
            die("Error: " . $this->conn->error);
        }
    }

    public function update($query) {
        $update_result = $this->conn->query($query) or die($this->conn->error.__LINE__);
        if ($update_result) {
            header("location: index.php");
        } else {
            die("Error: " . $this->conn->error);
        }
    }

    public function delete($query) {
        $deleted = $this->conn->query($query);
        if ($deleted) {
            return true;
        } else {
            die("Error: " . $this->conn->error);
        }
    }

}