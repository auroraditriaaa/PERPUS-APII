<nav class="navbar">
  <div class="navbar-brand">📚 Perpus API</div>
  <div class="navbar-menu">
    <a href="dashboard.php">Dashboard</a>
    <a href="data_buku.php">Data Buku</a>
    <a href="tambah.php">Tambah Buku</a>
    <a href="export_excel.php">Export Excel</a>
    <a href="export_pdf.php">Export PDF</a>
    <button type="button" id="toggleDarkMode" class="dark-toggle" title="Ganti tampilan gelap/terang">🌙</button>
    <a href="logout.php" class="logout" onclick="return confirm('Yakin ingin logout?')">
      Logout (<?= htmlspecialchars($_SESSION['admin_username'] ?? '') ?>)
    </a>
  </div>
</nav>
<script>
(function () {
  const tombol = document.getElementById('toggleDarkMode');
  const terapkan = (gelap) => {
    document.body.classList.toggle('dark', gelap);
    tombol.textContent = gelap ? '☀️' : '🌙';
  };
  terapkan(localStorage.getItem('perpusApiDarkMode') === '1');
  tombol.addEventListener('click', () => {
    const gelapBaru = !document.body.classList.contains('dark');
    localStorage.setItem('perpusApiDarkMode', gelapBaru ? '1' : '0');
    terapkan(gelapBaru);
  });
})();
</script>
