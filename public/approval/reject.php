<?php
session_start();
include "../../config/database.php";

$id = $_GET['id'];
$user = $_SESSION['user']['id'];

// Reject level
$conn->query("
UPDATE approvals 
SET status='rejected'
WHERE request_id=$id AND approver_id=$user
");

// Update final status
$conn->query("
UPDATE requests 
SET status='rejected'
WHERE id=$id
");

header("Location: ../request/detail.php?id=$id");
