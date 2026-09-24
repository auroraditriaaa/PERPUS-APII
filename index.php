<?php
require_once 'includes/auth.php';
require_once 'koneksi.php';

$totalBuku = $koneksi
    ->query("SELECT COUNT(*) AS total FROM books")
    ->fetch_assoc()['total'];

$jumlahKategori = $koneksi
    ->query("SELECT COUNT(DISTINCT kategori) AS total FROM books")
    ->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Perpus API - Perpustakaan Digital</title>

<link rel="stylesheet" href="style.css">

<style>

/* =========================================
   INDEX / LANDING PAGE
   CUTE DIGITAL LIBRARY
========================================= */

body {
    margin: 0;

    font-family: "Segoe UI", Arial, sans-serif;

    background:
        radial-gradient(
            circle at 10% 15%,
            #ffe5ed,
            transparent 25%
        ),
        radial-gradient(
            circle at 90% 80%,
            #dff6ff,
            transparent 28%
        ),
        #fffaf7;

    color: #536174;
}


/* NAVBAR */

nav,
header,
.navbar {

    background:
        linear-gradient(
            135deg,
            #fff7f9,
            #fffaf2,
            #eefaff
        ) !important;

    border-bottom:
        1px solid #f3dfe5 !important;

    box-shadow:
        0 5px 20px rgba(220,160,180,.12) !important;
}


/* HERO */

.hero {

    width: min(1180px, 92%);

    margin: 45px auto;

    min-height: 500px;

    display: grid;

    grid-template-columns:
        1fr 1fr;

    align-items: center;

    gap: 45px;

    padding: 55px;

    border-radius: 38px;

    background:
        linear-gradient(
            135deg,
            #fff0f4,
            #fffaf1
        );

    box-shadow:
        0 20px 45px
        rgba(215,160,175,.16);

    overflow: hidden;

    position: relative;
}


/* Dekorasi */

.hero::before {

    content: "✨";

    position: absolute;

    top: 35px;

    right: 45%;

    font-size: 40px;

    opacity: .5;
}


.hero::after {

    content: "📚";

    position: absolute;

    bottom: 20px;

    left: 45%;

    font-size: 65px;

    opacity: .08;
}


/* BADGE */

.hero-badge {

    display: inline-block;

    background: white;

    color: #ed7191;

    padding: 10px 18px;

    border-radius: 50px;

    font-size: 14px;

    font-weight: 700;

    margin-bottom: 18px;

    box-shadow:
        0 6px 15px rgba(220,150,170,.12);
}


/* JUDUL */

.hero h1 {

    margin: 0;

    font-size: clamp(40px, 5vw, 62px);

    line-height: 1.08;

    color: #40516b;

    font-weight: 800;
}


.hero h1 span {

    color: #ed7191;
}


/* DESKRIPSI */

.hero p {

    font-size: 17px;

    line-height: 1.7;

    color: #718096;

    max-width: 570px;

    margin: 22px 0;
}


/* BUTTON */

.hero-buttons {

    display: flex;

    gap: 12px;

    flex-wrap: wrap;
}


.btn-primary {

    display: inline-flex;

    align-items: center;

    gap: 8px;

    padding: 14px 24px;

    background:
        linear-gradient(
            135deg,
            #f47b9a,
            #f59ab1
        );

    color: white;

    text-decoration: none;

    border-radius: 50px;

    font-weight: 700;

    box-shadow:
        0 9px 20px
        rgba(241,117,148,.25);

    transition: .25s;
}


.btn-primary:hover {

    transform: translateY(-3px);

    box-shadow:
        0 13px 25px
        rgba(241,117,148,.35);
}


.btn-secondary {

    display: inline-flex;

    align-items: center;

    gap: 8px;

    padding: 14px 24px;

    background: white;

    color: #596579;

    text-decoration: none;

    border-radius: 50px;

    font-weight: 700;

    border: 1px solid #f1dce2;

    transition: .25s;
}


.btn-secondary:hover {

    background: #fff0f4;

    color: #ed7191;

    transform: translateY(-3px);
}


/* =========================================
   ILUSTRASI BUKU
========================================= */

.library-scene {

    min-height: 390px;

    display: flex;

    align-items: center;

    justify-content: center;

    position: relative;
}


/* Rak */

.bookshelf {

    width: 330px;

    height: 300px;

    background:
        linear-gradient(
            135deg,
            #f5cfae,
            #eab98f
        );

    border-radius: 25px;

    padding: 22px;

    box-shadow:
        0 20px 30px
        rgba(160,110,80,.20);

    position: relative;
}


/* Rak buku */

.shelf {

    height: 65px;

    background: #fff1d9;

    border-radius: 12px;

    margin-bottom: 10px;

    display: flex;

    align-items: flex-end;

    justify-content: center;

    gap: 7px;

    padding: 7px;

}


/* Buku */

.book {

    width: 24px;

    border-radius: 5px 5px 2px 2px;

    box-shadow:
        2px 3px 5px rgba(0,0,0,.12);
}


.book:nth-child(1) {

    height: 48px;

    background: #f49bb2;
}


.book:nth-child(2) {

    height: 55px;

    background: #9ed9e9;
}


.book:nth-child(3) {

    height: 42px;

    background: #f6d57e;
}


.book:nth-child(4) {

    height: 50px;

    background: #b9e2ce;
}


.book:nth-child(5) {

    height: 45px;

    background: #c8b8e8;
}


/* MASKOT */

.mascot {

    position: absolute;

    bottom: -25px;

    left: 50%;

    transform: translateX(-50%);

    width: 145px;

    height: 145px;

    background: #d9c0aa;

    border-radius: 50%;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 75px;

    box-shadow:
        0 15px 25px
        rgba(120,90,70,.18);
}


/* Buku yang dibaca */

.reading-book {

    position: absolute;

    bottom: 35px;

    left: 50%;

    transform: translateX(-50%);

    background: #f58da9;

    color: white;

    padding: 10px 18px;

    border-radius: 8px;

    font-size: 13px;

    font-weight: 700;

}


/* =========================================
   STATISTIK
========================================= */

.quick-stats {

    width: min(900px, 90%);

    margin: -5px auto 50px;

    display: grid;

    grid-template-columns:
        repeat(2, 1fr);

    gap: 20px;
}


.quick-card {

    background: white;

    border-radius: 25px;

    padding: 25px;

    text-align: center;

    box-shadow:
        0 10px 25px
        rgba(100,80,100,.08);

    border: 1px solid #f5e5e9;
}


.quick-card .icon {

    font-size: 32px;

    margin-bottom: 8px;
}


.quick-card strong {

    display: block;

    font-size: 30px;

    color: #45556d;
}


.quick-card span {

    color: #8994a5;

    font-size: 14px;
}


/* =========================================
   RESPONSIVE
========================================= */

@media (max-width: 800px) {

    .hero {

        grid-template-columns: 1fr;

        padding: 35px 25px;

        text-align: center;
    }


    .hero p {

        margin-left: auto;

        margin-right: auto;
    }


    .hero-buttons {

        justify-content: center;
    }


    .library-scene {

        min-height: 330px;
    }

}


@media (max-width: 500px) {

    .bookshelf {

        width: 280px;

        height: 270px;
    }


    .quick-stats {

        grid-template-columns: 1fr;
    }

}

</style>

</head>


<body>


<?php include 'includes/navbar.php'; ?>


<!-- =====================================
     HERO
===================================== -->

<section class="hero">


    <div class="hero-content">


        <div class="hero-badge">

            ✨ Perpustakaan Digital untuk Semua

        </div>


        <h1>

            Baca.

            <span>Jelajah.</span>

            Tumbuh.

        </h1>


        <p>

            Temukan berbagai koleksi buku menarik
            dan jelajahi dunia pengetahuan dengan
            mudah melalui Perpus API.

        </p>


        <div class="hero-buttons">


            <a
                href="data_buku.php"
                class="btn-primary"
            >

                📚 Jelajahi Buku

            </a>


            <a
                href="dashboard.php"
                class="btn-secondary"
            >

                📊 Dashboard

            </a>


        </div>


    </div>


    <!-- ILUSTRASI -->

    <div class="library-scene">


        <div class="bookshelf">


            <div class="shelf">

                <div class="book"></div>

                <div class="book"></div>

                <div class="book"></div>

                <div class="book"></div>

                <div class="book"></div>

            </div>


            <div class="shelf">

                <div class="book"></div>

                <div class="book"></div>

                <div class="book"></div>

                <div class="book"></div>

                <div class="book"></div>

            </div>


            <div class="shelf">

                <div class="book"></div>

                <div class="book"></div>

                <div class="book"></div>

                <div class="book"></div>

                <div class="book"></div>

            </div>


        </div>


        <div class="mascot">

            🐱

        </div>


        <div class="reading-book">

            📖 Membaca...

        </div>


    </div>


</section>



<!-- =====================================
     STATISTIK
===================================== -->

<section class="quick-stats">


    <div class="quick-card">

        <div class="icon">

            📚

        </div>


        <strong>

            <?= (int)$totalBuku ?>

        </strong>


        <span>

            Koleksi Buku

        </span>

    </div>



    <div class="quick-card">

        <div class="icon">

            🏷️

        </div>


        <strong>

            <?= (int)$jumlahKategori ?>

        </strong>


        <span>

            Kategori Buku

        </span>

    </div>


</section>


</body>

</html>