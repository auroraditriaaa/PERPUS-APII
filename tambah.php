<?php 
require_once 'includes/auth.php'; 
require_once 'koneksi.php'; 
 
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
            "INSERT INTO books (kode_buku, judul, penulis, kategori, tahun_terbit, penerbit) 
             VALUES (?, ?, ?, ?, ?, ?)" 
        ); 
        $stmt->bind_param("ssssis", $kode, $judul, $penulis, $kategori, $tahun, $penerbit); 
        $stmt->execute(); 
        $stmt->close(); 
        header("Location: data_buku.php"); 
        exit; 
    } else { 
        $error = "Semua field wajib diisi."; 
    } 
} 
?> 

<!DOCTYPE html> 
<html lang="id"> 

<head> 

<meta charset="UTF-8"> 

<meta name="viewport" content="width=device-width, initial-scale=1"> 

<title>Tambah Buku - Perpus API</title> 

<link rel="stylesheet" href="style.css"> 


<style>

/* =====================================================
   COZY WHIMSICAL LIBRARY - TAMBAH BUKU
===================================================== */

:root {

    --cream: #fffaf0;
    --cream-light: #fffdf7;
    --cream-dark: #f1e4d0;

    --green: #9bb99b;
    --green-dark: #6f916f;
    --green-light: #e6f0e3;

    --brown: #8b6b4f;
    --brown-dark: #5d4534;
    --brown-light: #eee1d0;

    --blue: #a9c9cf;
    --blue-light: #e6f2f4;

    --yellow: #f1d582;
    --yellow-light: #fff2c6;

    --white: #ffffff;

    --text: #514d45;
    --text-soft: #817b70;

    --border: #e5d9c6;

    --shadow:
        0 15px 35px rgba(91,72,52,.11);

}


/* =====================================================
   BODY
===================================================== */

body {

    margin: 0;

    font-family:
        "Trebuchet MS",
        "Segoe UI",
        Arial,
        sans-serif;

    color:
        var(--text);

    background:

        radial-gradient(
            circle at 7% 10%,
            rgba(241,213,130,.24),
            transparent 23%
        ),

        radial-gradient(
            circle at 93% 18%,
            rgba(169,201,207,.28),
            transparent 25%
        ),

        radial-gradient(
            circle at 50% 100%,
            rgba(155,185,155,.15),
            transparent 30%
        ),

        var(--cream);

}


/* =====================================================
   MAIN
===================================================== */

.container {

    width:
        min(900px, 92%);

    margin:
        42px auto 70px;

    display:
        flex;

    flex-direction:
        column;

    align-items:
        center;

}


/* =====================================================
   TITLE
===================================================== */

.container > h1 {

    position:
        relative;

    width:
        100%;

    max-width:
        760px;

    margin:
        0 0 25px;

    padding:
        28px 34px;

    overflow:
        hidden;

    border:
        1px solid var(--border);

    border-radius:
        28px;

    background:

        linear-gradient(
            135deg,
            #fffdf7 0%,
            #fff6d9 48%,
            #eaf4f1 100%
        );

    color:
        var(--brown-dark);

    font-family:
        Georgia,
        "Times New Roman",
        serif;

    font-size:
        32px;

    box-shadow:
        var(--shadow);

}


/* Matahari */

.container > h1::before {

    content:
        "☀️";

    position:
        absolute;

    right:
        35px;

    top:
        12px;

    font-family:
        Arial,
        sans-serif;

    font-size:
        48px;

    opacity:
        .28;

}


/* Buku */

.container > h1::after {

    content:
        "📚";

    position:
        absolute;

    right:
        95px;

    bottom:
        8px;

    font-family:
        Arial,
        sans-serif;

    font-size:
        34px;

    opacity:
        .28;

}


/* =====================================================
   ERROR
===================================================== */

.alert-error {

    width:
        100%;

    max-width:
        760px;

    margin:
        0 auto 18px;

    padding:
        14px 18px;

    border:
        1px solid #e7c7bc;

    border-radius:
        16px;

    background:
        #f9e7e0;

    color:
        #925747;

    font-size:
        14px;

    font-weight:
        700;

    box-shadow:
        0 6px 18px rgba(120,80,60,.06);

}


/* =====================================================
   FORM
===================================================== */

.form-buku {

    width:
        100%;

    max-width:
        760px;

    margin:
        0 auto;

    padding:
        34px 36px 30px;

    border:
        1px solid var(--border);

    border-radius:
        28px;

    background:
        rgba(255,255,255,.94);

    box-shadow:
        var(--shadow);

}


/* =====================================================
   LABEL
===================================================== */

.form-buku label {

    display:
        block;

    margin:
        0 0 8px;

    color:
        var(--brown-dark);

    font-size:
        14px;

    font-weight:
        800;

}


/* =====================================================
   INPUT
===================================================== */

.form-buku input {

    display:
        block;

    width:
        100%;

    height:
        48px;

    margin:
        0 0 20px;

    padding:
        0 16px;

    border:
        1px solid var(--border);

    border-radius:
        15px;

    outline:
        none;

    background:
        var(--cream-light);

    color:
        var(--text);

    font-family:
        inherit;

    font-size:
        14px;

    transition:
        all .25s ease;

}


/* Focus */

.form-buku input:focus {

    background:
        white;

    border-color:
        var(--green);

    box-shadow:
        0 0 0 4px rgba(155,185,155,.18);

}


/* Placeholder */

.form-buku input::placeholder {

    color:
        #aaa194;

}


/* =====================================================
   TAHUN
===================================================== */

#tahun_terbit {

    cursor:
        text;

}


/* =====================================================
   FORM ACTION
===================================================== */

.form-actions {

    display:
        flex;

    align-items:
        center;

    gap:
        10px;

    margin-top:
        8px;

    padding-top:
        7px;

}


/* =====================================================
   SIMPAN
===================================================== */

.form-actions button {

    min-width:
        112px;

    height:
        44px;

    padding:
        0 20px;

    border:
        none;

    border-radius:
        15px;

    background:
        var(--green-dark);

    color:
        white;

    font-family:
        inherit;

    font-size:
        13px;

    font-weight:
        900;

    cursor:
        pointer;

    box-shadow:
        0 7px 16px rgba(111,145,111,.22);

    transition:
        all .25s ease;

}


.form-actions button:hover {

    background:
        var(--brown);

    transform:
        translateY(-2px);

    box-shadow:
        0 9px 19px rgba(139,107,79,.22);

}


/* =====================================================
   BATAL
===================================================== */

.form-actions .btn-secondary {

    display:
        inline-flex;

    align-items:
        center;

    justify-content:
        center;

    min-width:
        92px;

    height:
        44px;

    padding:
        0 18px;

    border:
        1px solid #d5e5e7;

    border-radius:
        15px;

    background:
        var(--blue-light);

    color:
        #55777d !important;

    text-decoration:
        none;

    font-family:
        inherit;

    font-size:
        13px;

    font-weight:
        800;

    transition:
        all .25s ease;

}


.form-actions .btn-secondary:hover {

    background:
        var(--yellow-light);

    color:
        var(--brown-dark) !important;

    border-color:
        #eddcae;

    transform:
        translateY(-2px);

}


/* =====================================================
   DARK MODE
===================================================== */

body.dark-mode,
body.dark {

    background:
        #202923 !important;

    color:
        #eee9dc !important;

}


body.dark-mode .container > h1,
body.dark .container > h1 {

    background:
        linear-gradient(
            135deg,
            #2d3931,
            #3a382d,
            #304044
        ) !important;

    color:
        #fff7e5 !important;

    border-color:
        #4b574e !important;

}


body.dark-mode .form-buku,
body.dark .form-buku {

    background:
        #29352e !important;

    border-color:
        #465249 !important;

}


body.dark-mode .form-buku label,
body.dark .form-buku label {

    color:
        #eee5d4 !important;

}


body.dark-mode .form-buku input,
body.dark .form-buku input {

    background:
        #202923 !important;

    color:
        #f2eee2 !important;

    border-color:
        #526057 !important;

}


body.dark-mode .form-buku input:focus,
body.dark .form-buku input:focus {

    border-color:
        #9bb99b;

    box-shadow:
        0 0 0 4px rgba(155,185,155,.13);

}


body.dark-mode .alert-error,
body.dark .alert-error {

    background:
        #4a3731;

    color:
        #e8a895;

    border-color:
        #67483f;

}


body.dark-mode .form-actions .btn-secondary,
body.dark .form-actions .btn-secondary {

    background:
        #35484a;

    color:
        #c8dfe1 !important;

    border-color:
        #506568;

}


/* =====================================================
   RESPONSIVE
===================================================== */

@media (max-width: 700px) {

    .container {

        width:
            94%;

        margin:
            25px auto 50px;

    }


    .container > h1 {

        padding:
            24px 22px;

        font-size:
            26px;

        border-radius:
            22px;

    }


    .container > h1::before {

        right:
            18px;

        font-size:
            35px;

    }


    .container > h1::after {

        right:
            60px;

        font-size:
            26px;

    }


    .form-buku {

        padding:
            25px 20px;

        border-radius:
            22px;

    }


    .form-buku input {

        height:
            46px;

        margin-bottom:
            18px;

    }


    .form-actions {

        flex-direction:
            column;

        align-items:
            stretch;

    }


    .form-actions button,
    .form-actions .btn-secondary {

        width:
            100%;

    }

}

</style>

</head> 


<body> 


<?php include 'includes/navbar.php'; ?> 


<main class="container"> 


    <h1>
        Tambah Buku
    </h1>


    <?php if ($error): ?>

        <div class="alert-error">
            <?= htmlspecialchars($error) ?>
        </div>

    <?php endif; ?> 


    <form
        method="POST"
        action="tambah.php"
        class="form-buku"
    > 


        <label for="kode_buku">
            Kode Buku
        </label>

        <input
            type="text"
            id="kode_buku"
            name="kode_buku"
            required
        > 


        <label for="judul">
            Judul
        </label>

        <input
            type="text"
            id="judul"
            name="judul"
            required
        > 


        <label for="penulis">
            Penulis
        </label>

        <input
            type="text"
            id="penulis"
            name="penulis"
            required
        > 


        <label for="kategori">
            Kategori
        </label>

        <input
            type="text"
            id="kategori"
            name="kategori"
            required
        > 


        <label for="tahun_terbit">
            Tahun Terbit
        </label>

        <input
            type="number"
            id="tahun_terbit"
            name="tahun_terbit"
            min="1900"
            max="2100"
            required
        > 


        <label for="penerbit">
            Penerbit
        </label>

        <input
            type="text"
            id="penerbit"
            name="penerbit"
            required
        > 


        <div class="form-actions"> 

            <button type="submit">
                SIMPAN
            </button>


            <a
                href="data_buku.php"
                class="btn btn-secondary"
            >
                Batal
            </a>

        </div> 

    </form> 


</main> 


</body> 

</html>