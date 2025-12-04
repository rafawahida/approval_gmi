<?php
class User {

    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // cari user berdasarkan email
    public function findByEmail($email) {
        $email = $this->conn->real_escape_string($email);
        $query = $this->conn->query("SELECT * FROM users WHERE email='$email'");
        return $query->fetch_assoc();
    }
}
