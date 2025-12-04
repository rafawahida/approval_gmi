<?php
// echo "Proyek Garuda Mart Indonesia";

    session_start();
    include "config/database.php";
    include "models/User.php";
    include "controllers/AuthController.php";

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
        $auth = new AuthController($conn);
        $auth->login($_POST['email'], $_POST['password']);
        exit;
    }

    // jika sudah login → redirect dashboard
    if (isset($_SESSION['user'])) {
        header("Location: public/dashboard.php");
        exit;
    }

    header("Location: public/login.php");


?>
