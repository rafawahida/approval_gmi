<?php
session_start();
include "../../config/database.php";

$req = $conn->query("
SELECT r.*, u.name AS user_name 
FROM requests r
JOIN users u ON r.user_id = u.id
ORDER BY r.id DESC
");
?>
<h2>Daftar Permintaan</h2>

<table border="1">
<tr>
    <th>ID</th>
    <th>User</th>
    <th>Judul</th>
    <th>Status</th>
    <th>Aksi</th>
</tr>

<?php while ($r = $req->fetch_assoc()): ?>
<tr>
    <td><?= $r['id'] ?></td>
    <td><?= $r['user_name'] ?></td>
    <td><?= $r['title'] ?></td>
    <td><?= $r['status'] ?></td>
    <td><a href="detail.php?id=<?= $r['id'] ?>">Detail</a></td>
</tr>
<?php endwhile; ?>
</table>
