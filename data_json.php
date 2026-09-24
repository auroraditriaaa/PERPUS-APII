<?php
// =========================================================
// JSON API DATA BUKU
// Akses langsung: http://localhost/perpus_api/data_json.php
// =========================================================
require_once 'koneksi.php';
header('Content-Type: application/json; charset=utf-8');

$result = $koneksi->query(
    "SELECT id, kode_buku, judul, penulis, kategori, tahun_terbit, penerbit
     FROM books ORDER BY id ASC"
);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
