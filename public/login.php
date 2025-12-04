<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Login Sistem Approval</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body class="login-background">

<div class="login-wrapper">
    <div class="login-box">
        <h2 class="login-title">Login Approval</h2>

        <form action="../index.php" method="POST">
            <input type="hidden" name="login" value="1">

            <label>Email</label>
            <input type="text" name="email" placeholder="Masukkan email..." required>

            <label>Password</label>
            <input type="password" name="password" placeholder="Masukkan password..." required>

            <button type="submit" class="login-btn">Login</button>
        </form>
    </div>
</div>

</body>
</html>
