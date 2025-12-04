<?php
session_start();
include "../../config/database.php";

require "../../vendor/autoload.php"; // jika pakai PHPSpreadsheet

use PhpOffice\PhpSpreadsheet\IOFactory;

$file = $_FILES['excel']['tmp_name'];

$spreadsheet = IOFactory::load($file);
$sheet = $spreadsheet->getActiveSheet()->toArray();

foreach ($sheet as $i => $row) {
    if ($i == 0) continue; // skip header

    $code = $row[0];
    $desc = $row[1];

    $conn->query("INSERT INTO master_data (code, description) VALUES ('$code','$desc')");
}

echo "<script>alert('Upload sukses!'); window.location='index.php'</script>";
