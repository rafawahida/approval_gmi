<?php
session_start();
include "../../config/database.php";

$master = $conn->query("SELECT * FROM master_data");
?>
<h2>Form Pengajuan</h2>

<form action="store.php" method="POST">
    <label>Judul</label>
    <input type="text" name="title" required>

    <label>Deskripsi</label>
    <textarea name="description"></textarea>

    <label>Pilih Master</label>
    <select name="master_id">
        <?php while ($m = $master->fetch_assoc()): ?>
            <option value="<?= $m['id']; ?>"><?= $m['code']; ?> - <?= $m['description']; ?></option>
        <?php endwhile; ?>
    </select>

    <button type="submit">Kirim</button>
</form>
