<?php
// =========================================================
// PROTEKSI HALAMAN — panggil di paling atas setiap halaman
// yang hanya boleh diakses setelah login.
// =========================================================
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
