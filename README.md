# PERPUS_API — Aplikasi Data Buku Perpustakaan
Jobsheet Ujian Praktik ASTS Ganjil — XII RPL 1 SMK PGRI 2 Ponorogo

## 1. Isi Project
```
perpus_api/
├── index.php          -> Halaman Data Buku (tabel + Fetch API + cari/filter)
├── dashboard.php       -> Dashboard Admin (statistik dari database)
├── login.php           -> Login Admin
├── logout.php          -> Logout
├── koneksi.php         -> Koneksi ke database
├── data_json.php       -> JSON API data buku
├── tambah.php          -> Tambah buku (Create)
├── edit.php             -> Edit buku (Update)
├── hapus.php            -> Hapus buku (Delete)
├── export_excel.php    -> Export Excel (.xls, tanpa library)
├── export_pdf.php      -> Export PDF (tanpa library, pakai includes/SimplePDF.php)
├── style.css
├── includes/
│   ├── auth.php         -> Proteksi halaman (wajib login)
│   ├── navbar.php        -> Menu navigasi
│   └── SimplePDF.php     -> Pembuat PDF sederhana
├── assets/
└── sql/
    └── perpus_api.sql   -> Struktur + data awal database
```

## 2. Cara Menjalankan (Tahap 1–4 di jobsheet)
1. Salin folder ini ke `C:\xampp\htdocs\` sehingga menjadi `htdocs/perpus_api/`.
2. Jalankan **XAMPP Control Panel**, aktifkan **Apache** dan **MySQL**.
3. Buka `http://localhost/phpMyAdmin`.
4. Klik menu **Import**, pilih file `sql/perpus_api.sql`, lalu klik **Go**.
   (File ini otomatis membuat database `perpus_api`, tabel `books`, `admins`,
   mengisi 12 data buku contoh, dan 1 akun admin.)
5. Buka browser: `http://localhost/perpus_api/login.php`
6. Login dengan:
   - Username: `admin`
   - Password: `admin123`

## 3. Alur Aplikasi
Login → Dashboard (statistik) → Data Buku (Fetch API) → Tambah/Edit/Hapus → Export Excel/PDF → Logout

## 4. Catatan Teknis
- **Export Excel** memakai trik tabel HTML dengan header `Content-Type: application/vnd.ms-excel`,
  jadi tidak perlu Composer/PhpSpreadsheet. Jika ingin file `.xlsx` asli, install PhpSpreadsheet
  via Composer lalu ganti isi `export_excel.php` sesuai dokumentasi library tersebut.
- **Export PDF** memakai `includes/SimplePDF.php`, pembuat PDF minimal buatan sendiri
  (tanpa Dompdf/FPDF), sehingga langsung jalan di XAMPP standar.
- Password admin di data contoh disimpan polos (`admin123`) sesuai izin jobsheet bagian H.
  `login.php` sudah mendukung `password_hash()` juga, jadi tinggal ganti nilai di tabel
  `admins` dengan hasil `password_hash('admin123', PASSWORD_DEFAULT)` jika ingin versi aman.

### Mengganti password admin menjadi hash (disarankan)
1. Buka `http://localhost/perpus_api/buat_hash.php` di browser.
2. Isi username admin (mis. `admin`) dan password baru dalam bentuk polos (mis. `admin123`).
3. Klik **Buat Hash** — halaman akan menampilkan hasil hash dan sebuah query `UPDATE`.
4. Salin query `UPDATE` tersebut, buka phpMyAdmin -> database `perpus_api` -> tab **SQL**,
   tempel query-nya, lalu jalankan (Go).
5. Coba login lagi seperti biasa dengan password polosnya -- `login.php` otomatis mengenali
   password yang sudah di-hash lewat `password_verify()`.
6. **Hapus file `buat_hash.php` dari server** setelah selesai, karena halaman ini tidak
   dilindungi login dan tidak seharusnya diakses publik.
- Fitur tambahan yang sudah disertakan (nilai kreativitas): pencarian buku & filter kategori
  langsung di halaman Data Buku (poin V).

## 5. Checklist Pengujian (Bagian T Jobsheet)
Semua poin pada tabel pengujian sudah didukung oleh kode ini:
Database, tabel books & admins, 10+ data buku, login benar/salah, dashboard terproteksi,
statistik dari database, API JSON, Fetch API, tampil di tabel, tambah/edit/hapus,
export Excel, export PDF, logout.

## 6. Jawaban Refleksi Peserta Didik (Bagian A)
1. **Fungsi API** dalam aplikasi ini adalah menjembatani database di server dengan
   tampilan di browser, dengan menyediakan data buku dalam format yang bisa dibaca
   JavaScript (JSON) tanpa perlu memuat ulang halaman.
2. **Fungsi JSON** adalah sebagai format pertukaran data yang ringan dan mudah dibaca,
   baik oleh PHP (server) maupun JavaScript (client), sehingga keduanya bisa "berbicara"
   dengan struktur data yang sama.
3. Data API sebaiknya diambil dari database, bukan ditulis manual, karena data harus
   selalu **up-to-date**: begitu ada tambah/edit/hapus di database, API otomatis
   menampilkan data terbaru tanpa perlu mengubah kode program.
4. **Fungsi Fetch API** adalah untuk mengirim permintaan (request) dari JavaScript ke
   server secara asynchronous, lalu menerima responsnya (di sini berupa JSON) untuk
   ditampilkan ke halaman tanpa reload.
5. **Fungsi Login Admin** adalah membatasi akses ke fitur pengelolaan data (CRUD,
   dashboard) hanya untuk pengguna yang berwenang, sehingga data buku tidak bisa
   diubah sembarang orang.
6. **Fungsi Session PHP** adalah menyimpan status "sedang login" pada server selama
   pengguna berpindah-pindah halaman, sehingga aplikasi tahu siapa yang sedang login
   tanpa harus login ulang di setiap halaman.
7. Statistik jumlah buku bekerja dengan menjalankan query agregat ke database
   (`COUNT`, `COUNT DISTINCT`, `MAX`) setiap kali halaman dashboard dibuka, sehingga
   angkanya selalu sesuai kondisi data terkini.
8. Perbedaan CRUD: **Create** menambah data baru, **Read** menampilkan/membaca data,
   **Update** mengubah data yang sudah ada, **Delete** menghapus data dari database.
9. **Export Excel** bekerja dengan mengambil seluruh data buku dari database lalu
   menuliskannya sebagai tabel HTML yang dikirim ke browser dengan header khusus
   sehingga dikenali dan dibuka sebagai file spreadsheet oleh Excel.
10. **Export PDF** bekerja dengan mengambil data dari database, menyusunnya menjadi
    baris-baris teks, lalu menuliskannya ke dalam struktur file PDF (objek halaman,
    konten teks, font) yang dikirim ke browser sebagai file unduhan.
11–13. *(Diisi sendiri oleh peserta didik sesuai pengalaman masing-masing saat
    mengerjakan — misalnya kendala koneksi database, error query, atau ide fitur
    tambahan seperti grafik statistik dan mode gelap.)*
