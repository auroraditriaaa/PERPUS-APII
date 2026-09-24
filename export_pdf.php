<?php

require_once 'includes/auth.php';
require_once 'koneksi.php';
require_once 'includes/SimplePDF.php';


/* =====================================================
   FILTER
===================================================== */

$cari     = trim($_GET['cari'] ?? '');
$kategori = trim($_GET['kategori'] ?? '');


/* =====================================================
   QUERY DATA
===================================================== */

$sql = "SELECT
            id,
            kode_buku,
            judul,
            penulis,
            kategori,
            tahun_terbit,
            penerbit
        FROM books
        WHERE 1=1";

$types  = "";
$params = [];


/* =====================================================
   PENCARIAN
   KODE + JUDUL + PENULIS + PENERBIT
===================================================== */

if ($cari !== '') {

    $sql .= " AND (
                kode_buku LIKE ?
                OR judul LIKE ?
                OR penulis LIKE ?
                OR penerbit LIKE ?
              )";

    $like = "%" . $cari . "%";

    $types .= "ssss";

    $params[] = $like;
    $params[] = $like;
    $params[] = $like;
    $params[] = $like;
}


/* =====================================================
   FILTER KATEGORI
===================================================== */

if ($kategori !== '') {

    $sql .= " AND kategori = ?";

    $types .= "s";

    $params[] = $kategori;
}


/* =====================================================
   URUTKAN DATA
===================================================== */

$sql .= " ORDER BY id ASC";


/* =====================================================
   EKSEKUSI QUERY
===================================================== */

$stmt = $koneksi->prepare($sql);

if (!$stmt) {
    die("Query gagal diproses.");
}

if ($types !== '') {

    $stmt->bind_param(
        $types,
        ...$params
    );
}

$stmt->execute();

$result = $stmt->get_result();


/* =====================================================
   SIMPAN DATA
===================================================== */

$dataBuku = [];

while ($row = $result->fetch_assoc()) {

    $dataBuku[] = $row;
}

$stmt->close();


/* =====================================================
   INFORMASI
===================================================== */

$jumlahData  = count($dataBuku);
$tanggalCetak = date("d-m-Y");


/* =====================================================
   FUNGSI POTONG TEKS
===================================================== */

function potong($text, $panjang)
{
    $text = trim((string)$text);

    if (strlen($text) > $panjang) {

        return substr(
            $text,
            0,
            $panjang - 3
        ) . "...";
    }

    return $text;
}


/* =====================================================
   KOLOM KIRI
===================================================== */

function kolomKiri($text, $lebar)
{
    $text = potong(
        $text,
        $lebar
    );

    return str_pad(
        $text,
        $lebar,
        " ",
        STR_PAD_RIGHT
    );
}


/* =====================================================
   KOLOM TENGAH
===================================================== */

function kolomTengah($text, $lebar)
{
    $text = potong(
        $text,
        $lebar
    );

    $panjang = strlen($text);

    $sisa = $lebar - $panjang;

    $kiri = floor($sisa / 2);

    $kanan = $sisa - $kiri;

    return
        str_repeat(" ", $kiri)
        . $text
        . str_repeat(" ", $kanan);
}


/* =====================================================
   LEBAR KOLOM
   TOTAL LEBIH BESAR AGAR MEMENUHI A4 LANDSCAPE
===================================================== */

$W_NO       = 5;
$W_KODE     = 13;
$W_JUDUL    = 30;
$W_PENULIS  = 23;
$W_KATEGORI = 15;
$W_TAHUN    = 8;
$W_PENERBIT = 22;


/* =====================================================
   GARIS TABEL
===================================================== */

$garis =
      "+"
    . str_repeat("-", $W_NO)
    . "+"
    . str_repeat("-", $W_KODE)
    . "+"
    . str_repeat("-", $W_JUDUL)
    . "+"
    . str_repeat("-", $W_PENULIS)
    . "+"
    . str_repeat("-", $W_KATEGORI)
    . "+"
    . str_repeat("-", $W_TAHUN)
    . "+"
    . str_repeat("-", $W_PENERBIT)
    . "+";


/* =====================================================
   LEBAR TOTAL TABEL
===================================================== */

$LEBAR_TOTAL = strlen($garis);


/* =====================================================
   HEADER TABEL
===================================================== */

$headerTabel =
      "|"
    . kolomTengah("NO", $W_NO)
    . "|"
    . kolomTengah("KODE BUKU", $W_KODE)
    . "|"
    . kolomTengah("JUDUL BUKU", $W_JUDUL)
    . "|"
    . kolomTengah("PENULIS", $W_PENULIS)
    . "|"
    . kolomTengah("KATEGORI", $W_KATEGORI)
    . "|"
    . kolomTengah("TAHUN", $W_TAHUN)
    . "|"
    . kolomTengah("PENERBIT", $W_PENERBIT)
    . "|";


/* =====================================================
   TEKS TENGAH
===================================================== */

function teksTengah($text, $lebar)
{
    $text = (string)$text;

    if (strlen($text) >= $lebar) {

        return substr(
            $text,
            0,
            $lebar
        );
    }

    $sisa = $lebar - strlen($text);

    $kiri = floor($sisa / 2);

    $kanan = $sisa - $kiri;

    return
        str_repeat(" ", $kiri)
        . $text
        . str_repeat(" ", $kanan);
}


/* =====================================================
   POSISI TENGAH TABEL
===================================================== */

/*
 * SimplePDF menggunakan Courier.
 *
 * Ukuran Courier 10 pt kira-kira
 * 6 point per karakter.
 *
 * A4 landscape = 842 point.
 */

$LEBAR_HURUF = 6;

$LEBAR_TABEL_POINT =
    $LEBAR_TOTAL * $LEBAR_HURUF;


/*
 * Hitung posisi X supaya tabel benar-benar CENTER.
 */

$X_TABEL =
    (842 - $LEBAR_TABEL_POINT) / 2;


/*
 * Jangan terlalu dekat dengan tepi.
 */

if ($X_TABEL < 30) {

    $X_TABEL = 30;
}


/* =====================================================
   POSISI TEKS INFORMASI
===================================================== */

$X_INFO = 80;


/* =====================================================
   BUAT PDF
===================================================== */

$pdf = new SimplePDF();


/* =====================================================
   HEADER
===================================================== */

$pdf->addCenteredLine(
    "PERPUSTAKAAN DIGITAL",
    15
);

$pdf->addCenteredLine(
    "PERPUS API",
    12
);

$pdf->addSpace(8);

$pdf->addCenteredLine(
    "LAPORAN DATA BUKU PERPUSTAKAAN",
    14
);

$pdf->addSpace(12);


/* =====================================================
   INFORMASI LAPORAN
===================================================== */

$pdf->addLine(
    "Tanggal Cetak : " . $tanggalCetak,
    10,
    $X_INFO
);


if ($cari !== '') {

    $pdf->addLine(
        'Pencarian     : "' .
        potong($cari, 60) .
        '"',
        10,
        $X_INFO
    );

} else {

    $pdf->addLine(
        "Pencarian     : Semua Buku",
        10,
        $X_INFO
    );
}


if ($kategori !== '') {

    $pdf->addLine(
        "Kategori      : " .
        potong($kategori, 60),
        10,
        $X_INFO
    );

} else {

    $pdf->addLine(
        "Kategori      : Semua Kategori",
        10,
        $X_INFO
    );
}


$pdf->addLine(
    "Jumlah Data   : " .
    $jumlahData .
    " buku",
    10,
    $X_INFO
);


$pdf->addSpace(10);


/* =====================================================
   TABEL
===================================================== */

$pdf->addLine(
    $garis,
    9,
    $X_TABEL
);

$pdf->addLine(
    $headerTabel,
    9,
    $X_TABEL
);

$pdf->addLine(
    $garis,
    9,
    $X_TABEL
);


/* =====================================================
   DATA BUKU
===================================================== */

if ($jumlahData > 0) {

    $no = 1;

    foreach ($dataBuku as $row) {

        $baris =
              "|"
            . kolomTengah(
                $no,
                $W_NO
            )
            . "|"
            . kolomKiri(
                $row['kode_buku'],
                $W_KODE
            )
            . "|"
            . kolomKiri(
                $row['judul'],
                $W_JUDUL
            )
            . "|"
            . kolomKiri(
                $row['penulis'],
                $W_PENULIS
            )
            . "|"
            . kolomKiri(
                $row['kategori'],
                $W_KATEGORI
            )
            . "|"
            . kolomTengah(
                $row['tahun_terbit'],
                $W_TAHUN
            )
            . "|"
            . kolomKiri(
                $row['penerbit'],
                $W_PENERBIT
            )
            . "|";


        $pdf->addLine(
            $baris,
            9,
            $X_TABEL
        );


        $no++;
    }

} else {

    $kosong =
          "|"
        . teksTengah(
            "TIDAK ADA DATA BUKU",
            $LEBAR_TOTAL - 2
        )
        . "|";


    $pdf->addLine(
        $kosong,
        9,
        $X_TABEL
    );
}


/* =====================================================
   PENUTUP TABEL
===================================================== */

$pdf->addLine(
    $garis,
    9,
    $X_TABEL
);


$pdf->addSpace(15);


/* =====================================================
   RINGKASAN
===================================================== */

$pdf->addCenteredLine(
    "RINGKASAN LAPORAN",
    11
);

$pdf->addSpace(5);


$pdf->addLine(
    "Total buku yang ditampilkan : " .
    $jumlahData .
    " buku",
    10,
    $X_INFO
);


if ($cari !== '') {

    $pdf->addLine(
        'Kata pencarian             : "' .
        potong($cari, 50) .
        '"',
        10,
        $X_INFO
    );
}


if ($kategori !== '') {

    $pdf->addLine(
        "Kategori                    : " .
        potong($kategori, 50),
        10,
        $X_INFO
    );
}


/* =====================================================
   FOOTER
===================================================== */

$pdf->addSpace(18);


$pdf->addCenteredLine(
    "Perpus API - Sistem Perpustakaan Digital",
    9
);

$pdf->addCenteredLine(
    "Laporan dibuat secara otomatis oleh sistem",
    8
);


/* =====================================================
   NAMA FILE
===================================================== */

$namaFile =
    "laporan_data_buku";


if ($cari !== '') {

    $namaFile .=
        "_pencarian";
}


if ($kategori !== '') {

    $kategoriFile =
        preg_replace(
            '/[^A-Za-z0-9_-]/',
            '',
            $kategori
        );

    $namaFile .=
        "_" .
        $kategoriFile;
}


$namaFile .= ".pdf";


/* =====================================================
   OUTPUT
===================================================== */

$pdf->output(
    $namaFile
);

exit;

?>