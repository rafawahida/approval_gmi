<?php
session_start();
include "../../config/database.php";

$id = $_GET['id'];

$r = $conn->query("
SELECT r.*, u.name
FROM requests r
JOIN users u ON r.user_id = u.id
WHERE r.id=$id
")->fetch_assoc();

// Cek approval
$a = $conn->query("
SELECT a.*, u.name AS approver
FROM approvals a
JOIN users u ON a.approver_id = u.id
WHERE request_id=$id
");
?>

<h2>Detail Permintaan</h2>

<p><b>Judul:</b> <?= $r['title']; ?></p>
<p><b>Diajukan oleh:</b> <?= $r['name']; ?></p>
<p><b>Status:</b> <?= $r['status']; ?></p>

<h3>Approval</h3>
<table border="1">
<tr>
    <th>Level</th><th>Approver</th><th>Status</th><th>Aksi</th>
</tr>

<?php while ($d = $a->fetch_assoc()): ?>
<tr>
    <td><?= $d['level'] ?></td>
    <td><?= $d['approver'] ?></td>
    <td><?= $d['status'] ?></td>
    <td>
        <?php if ($d['approver_id'] == $_SESSION['user']['id'] && $d['status']=='pending'): ?>
            <a href="../approval/approve.php?id=<?= $id ?>">Approve</a> |
            <a href="../approval/reject.php?id=<?= $id ?>">Reject</a>
        <?php endif; ?>
    </td>
</tr>
<?php endwhile; ?>
</table>
