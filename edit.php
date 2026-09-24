<?php
require_once 'includes/auth.php';
require_once 'koneksi.php';

$id = (int) ($_GET['id'] ?? 0);
if ($id <= 0) {
    header("Location: data_buku.php");
    exit;
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode     = trim($_POST['kode_buku'] ?? '');
    $judul    = trim($_POST['judul'] ?? '');
    $penulis  = trim($_POST['penulis'] ?? '');
    $kategori = trim($_POST['kategori'] ?? '');
    $tahun    = (int) ($_POST['tahun_terbit'] ?? 0);
    $penerbit = trim($_POST['penerbit'] ?? '');

    if ($kode && $judul && $penulis && $kategori && $tahun && $penerbit) {
        $stmt = $koneksi->prepare(
            "UPDATE books SET kode_buku=?, judul=?, penulis=?, kategori=?, tahun_terbit=?, penerbit=?
             WHERE id=?"
        );
        $stmt->bind_param("ssssisi", $kode, $judul, $penulis, $kategori, $tahun, $penerbit, $id);
        $stmt->execute();
        $stmt->close();
        header("Location: data_buku.php");
        exit;
    } else {
        $error = "Semua field wajib diisi.";
    }
}

$stmt = $koneksi->prepare("SELECT * FROM books WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$buku = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$buku) {
    header("Location: data_buku.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Edit Buku - Perpus API</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'includes/navbar.php'; ?>
<main class="container">
  <h1>Edit Buku</h1>

  <?php if ($error): ?>
    <div class="alert-error"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <form method="POST" action="edit.php?id=<?= (int)$buku['id'] ?>" class="form-buku">
    <label for="kode_buku">Kode Buku</label>
    <input type="text" id="kode_buku" name="kode_buku" value="<?= htmlspecialchars($buku['kode_buku']) ?>" required>

    <label for="judul">Judul</label>
    <input type="text" id="judul" name="judul" value="<?= htmlspecialchars($buku['judul']) ?>" required>

    <label for="penulis">Penulis</label>
    <input type="text" id="penulis" name="penulis" value="<?= htmlspecialchars($buku['penulis']) ?>" required>

    <label for="kategori">Kategori</label>
    <input type="text" id="kategori" name="kategori" value="<?= htmlspecialchars($buku['kategori']) ?>" required>

    <label for="tahun_terbit">Tahun Terbit</label>
    <input type="number" id="tahun_terbit" name="tahun_terbit" min="1900" max="2100" value="<?= (int)$buku['tahun_terbit'] ?>" required>

    <label for="penerbit">Penerbit</label>
    <input type="text" id="penerbit" name="penerbit" value="<?= htmlspecialchars($buku['penerbit']) ?>" required>

    <div class="form-actions">
      <button type="submit">SIMPAN PERUBAHAN</button>
      <a href="data_buku.php" class="btn btn-secondary">Batal</a>
    </div>
  </form>
</main>
</body>
</html>
