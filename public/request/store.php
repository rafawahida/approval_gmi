<?php
session_start();
include "../../config/database.php";

$user_id = $_SESSION['user']['id'];
$title = $_POST['title'];
$desc = $_POST['description'];
$master = $_POST['master_id'];

$conn->query("INSERT INTO requests (user_id, master_id, title, description)
VALUES ($user_id, $master, '$title', '$desc')");

$req_id = $conn->insert_id;

// Set approval awal oleh leader (role = 2)
$leader = $conn->query("SELECT id FROM users WHERE role=2 LIMIT 1")->fetch_assoc();

$conn->query("
INSERT INTO approvals (request_id, approver_id, level)
VALUES ($req_id, ".$leader['id'].", 2)
");

header("Location: list.php");
