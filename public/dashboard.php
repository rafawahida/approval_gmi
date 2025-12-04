<?php
session_start();
if (!isset($_SESSION['user'])) { header("Location: login.php"); exit; }
include "../config/database.php";

$user = $_SESSION['user'];
$role = $user['role'];
$user_id = $user['id'];

// Hitung data grafik global
$total_pending   = $conn->query("SELECT COUNT(*) AS j FROM requests WHERE status='pending'")->fetch_assoc()['j'];
$total_approved  = $conn->query("SELECT COUNT(*) AS j FROM requests WHERE status='approved'")->fetch_assoc()['j'];
$total_rejected  = $conn->query("SELECT COUNT(*) AS j FROM requests WHERE status='rejected'")->fetch_assoc()['j'];

// Hitung request milik user (hanya role 1)
if ($role == 1) {
    $my_total = $conn->query("SELECT COUNT(*) AS j FROM requests WHERE user_id=$user_id")->fetch_assoc()['j'];
    $my_pending = $conn->query("SELECT COUNT(*) AS j FROM requests WHERE user_id=$user_id AND status='pending'")->fetch_assoc()['j'];
    $my_approved = $conn->query("SELECT COUNT(*) AS j FROM requests WHERE user_id=$user_id AND status='approved'")->fetch_assoc()['j'];
    $my_rejected = $conn->query("SELECT COUNT(*) AS j FROM requests WHERE user_id=$user_id AND status='rejected'")->fetch_assoc()['j'];
}

// Hitung request yang menunggu approval sesuai role
$waiting_approval = 0;
if ($role > 1) {
    $waiting_approval = $conn->query("
        SELECT COUNT(*) AS j 
        FROM approvals 
        WHERE approver_id = $user_id AND status='pending'
    ")->fetch_assoc()['j'];
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

<div class="layout">

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-title">Approval App</div>

        <nav>
            <a href="dashboard.php">📊 Dashboard</a>
            <a href="request/list.php">📄 Daftar Request</a>

            <?php if ($role == 1): ?>
                <a href="request/create.php">➕ Buat Request</a>
            <?php endif; ?>

            <?php if ($role > 1): ?>
                <a href="master/index.php">📂 Data Master</a>
            <?php endif; ?>

            <a href="logout.php" class="logout">🚪 Logout</a>
        </nav>
    </aside>

    <!-- CONTENT -->
    <main class="content">

        <div class="header">
            <h2>Hi, <?= $user['name']; ?> 👋</h2>
            <!-- <p>Role: <?= $role; ?> (1=User, 2=Leader, 3=SPV, 4=Manager)</p> -->
        </div>

        <!-- CARD STATISTICS -->

        <div class="card">
            <h3>Statistik Permintaan (Semua User)</h3>
            <canvas id="chartStatus"></canvas>
        </div>

        <?php if ($role == 1): ?>
            <!-- CARD USER INFO -->
            <div class="card">
                <h3>Statistik Permintaan Saya</h3>
                <p>Total Request Saya: <b><?= $my_total ?></b></p>
                <p>Pending: <b><?= $my_pending ?></b></p>
                <p>Approved: <b><?= $my_approved ?></b></p>
                <p>Rejected: <b><?= $my_rejected ?></b></p>
            </div>
        <?php endif; ?>

        <?php if ($role > 1): ?>
            <!-- CARD APPROVAL WAITING -->
            <div class="card">
                <h3>Approval Menunggu Anda</h3>
                <p>Jumlah request menunggu approval: <b><?= $waiting_approval ?></b></p>
            </div>
        <?php endif; ?>

    </main>

</div>

<script>
const ctx = document.getElementById('chartStatus');

new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Pending', 'Approved', 'Rejected'],
        datasets: [{
            data: [<?= $total_pending ?>, <?= $total_approved ?>, <?= $total_rejected ?>],
            backgroundColor: ['#f1c40f','#2ecc71','#e74c3c']
        }]
    },
});
</script>

</body>
</html>
