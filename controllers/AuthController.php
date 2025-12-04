<?php
class AuthController {

    private $conn;
    private $userModel;

    public function __construct($db) {
        $this->conn = $db;
        $this->userModel = new User($db);
    }

    public function login($email, $password) {

        $user = $this->userModel->findByEmail($email);

        if ($user && $user['password'] === md5($password)) {

            $_SESSION['user'] = $user;

            header("Location: public/dashboard.php");
            exit;

        } else {
            echo "<script>alert('Email atau password salah!'); window.location='public/login.php';</script>";
            exit;
        }
    }
}
