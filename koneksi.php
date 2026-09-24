<?php
// =========================================================
// KONEKSI DATABASE
// =========================================================
$host   = "localhost";
$user   = "root";
$pass   = "";
$dbname = "perpus_api";

$koneksi = new mysqli($host, $user, $pass, $dbname);

if ($koneksi->connect_error) {
    die("Koneksi database gagal: " . $koneksi->connect_error);
}

$koneksi->set_charset("utf8mb4");
