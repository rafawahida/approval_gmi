<?php
session_start();
if ($_SESSION['user']['role'] <= 1) {
    die("Akses hanya leader+");
}
?>
<h2>Import Data Master (Excel)</h2>

<form action="process_upload.php" method="POST" enctype="multipart/form-data">
    <input type="file" name="excel" accept=".xlsx,.xls" required>
    <button type="submit">Upload</button>
</form>
