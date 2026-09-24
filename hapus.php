<?php
require_once 'includes/auth.php';
require_once 'koneksi.php';

$id = (int) ($_GET['id'] ?? 0);

if ($id > 0) {
    $stmt = $koneksi->prepare("DELETE FROM books WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

header("Location: data_buku.php");
exit;
