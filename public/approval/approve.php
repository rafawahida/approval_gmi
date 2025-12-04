<?php
session_start();
include "../../config/database.php";

$id = $_GET['id'];
$user = $_SESSION['user']['id'];

// Approve level ini
$conn->query("
UPDATE approvals 
SET status='approved'
WHERE request_id=$id AND approver_id=$user
");

// Cek level
$curr = $conn->query("
SELECT level FROM approvals 
WHERE request_id=$id AND approver_id=$user
")->fetch_assoc()['level'];

// Jika masih bisa lanjut
if ($curr < 4) {
    $next = $curr + 1;
    $next_user = $conn->query("SELECT id FROM users WHERE role=$next")->fetch_assoc()['id'];

    $conn->query("
    INSERT INTO approvals (request_id, approver_id, level)
    VALUES ($id, $next_user, $next)
    ");

    $conn->query("UPDATE requests SET current_approval_level=$next WHERE id=$id");

} else {
    $conn->query("UPDATE requests SET status='approved' WHERE id=$id");
}

header("Location: ../request/detail.php?id=$id");
