<?php
// =========================================================
// EXPORT EXCEL (tanpa library eksternal)
// Trik: kirim tabel HTML dengan header Content-Type Excel.
// Microsoft Excel akan membukanya sebagai file spreadsheet biasa.
// Jika ingin file .xlsx "asli", ganti bagian ini dengan
// library PhpSpreadsheet (lihat catatan di README.md).
// =========================================================
require_once 'includes/auth.php';
require_once 'koneksi.php';

// Filter opsional dari halaman Data Buku (hasil pencarian / kategori)
$cari     = trim($_GET['cari'] ?? '');
$kategori = trim($_GET['kategori'] ?? '');

$sql = "SELECT * FROM books WHERE 1=1";
$types = "";
$params = [];

if ($cari !== '') {
    $sql .= " AND (
    judul LIKE ?
    OR penulis LIKE ?
    OR kode_buku LIKE ?
    OR penerbit LIKE ?
)";
    $like = "%{$cari}%";
    $types .= "ssss";
    $params[] = $like;
    $params[] = $like;
    $params[] = $like;
    $params[] = $like;
}

if ($kategori !== '') {
    $sql .= " AND kategori = ?";
    $types .= "s";
    $params[] = $kategori;
}
$sql .= " ORDER BY id ASC";

$stmt = $koneksi->prepare($sql);
if ($types !== '') {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

$namaFile = "data_buku" . ($kategori !== '' ? "_" . preg_replace('/[^A-Za-z0-9_-]/', '', $kategori) : "") . ".xls";

header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename={$namaFile}");
header("Pragma: no-cache");
header("Expires: 0");

echo "\xEF\xBB\xBF"; // BOM supaya karakter tampil benar di Excel
?>
<table border="1">
  <tr>
    <th colspan="7">
      Laporan Data Buku
      <?= $kategori !== '' ? '- Kategori: ' . htmlspecialchars($kategori) : '' ?>
      <?= $cari !== '' ? '- Pencarian: "' . htmlspecialchars($cari) . '"' : '' ?>
    </th>
  </tr>
  <tr>
    <th>NO</th>
    <th>KODE BUKU</th>
    <th>JUDUL</th>
    <th>PENULIS</th>
    <th>KATEGORI</th>
    <th>TAHUN TERBIT</th>
    <th>PENERBIT</th>
  </tr>
  <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
  <tr>
    <td><?= $no++ ?></td>
    <td><?= htmlspecialchars($row['kode_buku']) ?></td>
    <td><?= htmlspecialchars($row['judul']) ?></td>
    <td><?= htmlspecialchars($row['penulis']) ?></td>
    <td><?= htmlspecialchars($row['kategori']) ?></td>
    <td><?= htmlspecialchars($row['tahun_terbit']) ?></td>
    <td><?= htmlspecialchars($row['penerbit']) ?></td>
  </tr>
  <?php endwhile; ?>
</table>
