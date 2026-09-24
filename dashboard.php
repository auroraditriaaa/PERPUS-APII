<?php
require_once 'includes/auth.php';
require_once 'koneksi.php';

$totalBuku      = $koneksi->query("SELECT COUNT(*) AS total FROM books")->fetch_assoc()['total'];
$jumlahKategori = $koneksi->query("SELECT COUNT(DISTINCT kategori) AS total FROM books")->fetch_assoc()['total'];
$jumlahPenulis  = $koneksi->query("SELECT COUNT(DISTINCT penulis) AS total FROM books")->fetch_assoc()['total'];
$tahunTerbaru   = $koneksi->query("SELECT MAX(tahun_terbit) AS tahun FROM books")->fetch_assoc()['tahun'];

// Data untuk grafik
$grafikKategori = [];

$res = $koneksi->query("
    SELECT kategori, COUNT(*) AS jumlah
    FROM books
    GROUP BY kategori
    ORDER BY jumlah DESC
");

while ($row = $res->fetch_assoc()) {
    $grafikKategori[] = $row;
}

$labelKategori = array_column($grafikKategori, 'kategori');
$jumlahPerKategori = array_column($grafikKategori, 'jumlah');
?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Dashboard - Perpus API</title>

<link rel="stylesheet" href="style.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>

<style>

/* =====================================================
   DASHBOARD - COZY WHIMSICAL LIBRARY
===================================================== */

:root {

    --cream: #FFF9EE;
    --cream-soft: #FFFDF7;
    --cream-dark: #F3E7D3;

    --green: #9DB89B;
    --green-dark: #6F9270;
    --green-soft: #E7F0E3;

    --brown: #8B6B4F;
    --brown-dark: #5F4635;
    --brown-soft: #EFE2D2;

    --blue: #AFCBD0;
    --blue-soft: #E7F3F4;

    --yellow: #F3D88B;
    --yellow-soft: #FFF3C9;

    --white: #FFFFFF;

    --text: #4B4A42;
    --text-soft: #777568;

    --border: #E8DDC9;

    --shadow:
        0 12px 30px rgba(91, 72, 52, .10);

    --shadow-hover:
        0 18px 35px rgba(91, 72, 52, .15);

}


/* =====================================================
   GLOBAL
===================================================== */

* {
    box-sizing: border-box;
}

body {

    margin: 0;

    font-family:
        "Trebuchet MS",
        "Segoe UI",
        Arial,
        sans-serif;

    background:

        radial-gradient(
            circle at 8% 12%,
            rgba(243, 216, 139, .28),
            transparent 23%
        ),

        radial-gradient(
            circle at 90% 20%,
            rgba(175, 203, 208, .30),
            transparent 25%
        ),

        var(--cream);

    color: var(--text);

    transition:
        background .35s ease,
        color .35s ease;

}


/* =====================================================
   NAVBAR
===================================================== */

nav,
header,
.navbar {

    background:
        rgba(255, 253, 247, .94) !important;

    color:
        var(--text) !important;

    border-bottom:
        1px solid var(--border) !important;

    box-shadow:
        0 5px 18px rgba(91,72,52,.07) !important;

    backdrop-filter:
        blur(8px);

}


nav a,
header a,
.navbar a {

    color:
        var(--brown-dark) !important;

    transition:
        all .25s ease;

}


nav a:hover,
header a:hover,
.navbar a:hover {

    color:
        var(--green-dark) !important;

    background:
        var(--green-soft) !important;

    border-radius:
        20px;

}


nav a:first-child,
header a:first-child,
.navbar a:first-child {

    font-weight:
        800;

    color:
        var(--green-dark) !important;

}


nav a[href*="logout"],
header a[href*="logout"],
.navbar a[href*="logout"] {

    color:
        var(--brown) !important;

}


nav a[href*="logout"]:hover,
header a[href*="logout"]:hover,
.navbar a[href*="logout"]:hover {

    background:
        var(--brown-soft) !important;

    color:
        var(--brown-dark) !important;

}


nav button,
header button,
.navbar button {

    background:
        var(--white) !important;

    color:
        var(--brown-dark) !important;

    border:
        1px solid var(--border) !important;

    border-radius:
        18px !important;

    transition:
        all .25s ease;

}


nav button:hover,
header button:hover,
.navbar button:hover {

    background:
        var(--yellow-soft) !important;

    transform:
        translateY(-2px);

}


/* =====================================================
   CONTAINER
===================================================== */

.container {

    width:
        min(1180px, 92%);

    margin:
        35px auto 70px;

}


/* =====================================================
   HERO DASHBOARD
===================================================== */

.dashboard-header {

    position:
        relative;

    overflow:
        hidden;

    min-height:
        245px;

    padding:
        42px 45px;

    margin-bottom:
        28px;

    border-radius:
        30px;

    background:

        linear-gradient(
            135deg,
            #FFFDF7 0%,
            #FFF7DC 48%,
            #EAF4F1 100%
        );

    border:
        1px solid
        rgba(232,221,201,.9);

    box-shadow:
        var(--shadow);

    transition:
        all .35s ease;

}


/*
   SUNLIGHT
*/

.dashboard-header::before {

    content:
        "";

    position:
        absolute;

    width:
        260px;

    height:
        260px;

    right:
        -60px;

    top:
        -90px;

    border-radius:
        50%;

    background:
        rgba(243,216,139,.32);

    filter:
        blur(3px);

}


/*
   WINDOW LIGHT
*/

.dashboard-header::after {

    content:
        "";

    position:
        absolute;

    right:
        35px;

    bottom:
        -20px;

    width:
        210px;

    height:
        155px;

    background:

        linear-gradient(
            90deg,
            transparent 30%,
            rgba(255,255,255,.55) 31%,
            rgba(255,255,255,.55) 34%,
            transparent 35%
        ),

        linear-gradient(
            0deg,
            transparent 42%,
            rgba(255,255,255,.55) 43%,
            rgba(255,255,255,.55) 46%,
            transparent 47%
        ),

        rgba(255,255,255,.18);

    border:
        12px solid
        rgba(139,107,79,.12);

    border-radius:
        8px;

    transform:
        rotate(-3deg);

    opacity:
        .75;

}


/* =====================================================
   SMALL DECORATIONS
===================================================== */

.dashboard-header .welcome-badge::before {

    content:
        "🌿";

    font-size:
        15px;

}


.welcome-badge {

    position:
        relative;

    z-index:
        5;

    display:
        inline-flex;

    align-items:
        center;

    gap:
        8px;

    background:
        rgba(255,255,255,.85);

    color:
        var(--green-dark);

    border:
        1px solid var(--border);

    border-radius:
        30px;

    padding:
        9px 16px;

    font-size:
        13px;

    font-weight:
        700;

    margin-bottom:
        15px;

    box-shadow:
        0 5px 15px rgba(91,72,52,.07);

}


/* =====================================================
   HERO TEXT
===================================================== */

.dashboard-header h1 {

    position:
        relative;

    z-index:
        5;

    margin:
        0 0 10px;

    max-width:
        650px;

    font-family:
        Georgia,
        "Times New Roman",
        serif;

    font-size:
        38px;

    line-height:
        1.2;

    color:
        var(--brown-dark);

    font-weight:
        800;

}


.dashboard-header h1::after {

    content:
        " ☀️";

    font-family:
        Arial,
        sans-serif;

}


.dashboard-header p {

    position:
        relative;

    z-index:
        5;

    margin:
        0;

    max-width:
        600px;

    color:
        var(--text-soft);

    font-size:
        15px;

    line-height:
        1.7;

}


/* =====================================================
   BOOK + CAT DECORATION
===================================================== */

.dashboard-header {

    --book-shadow:
        rgba(95,70,53,.15);

}


.dashboard-header h1::before {

    content:
        "📚";

    position:
        absolute;

    right:
        -440px;

    top:
        35px;

    font-size:
        55px;

    opacity:
        .85;

}


/* =====================================================
   STATISTICS
===================================================== */

.stat-grid {

    display:
        grid;

    grid-template-columns:
        repeat(4, 1fr);

    gap:
        18px;

    margin-bottom:
        28px;

}


.stat-card {

    position:
        relative;

    overflow:
        hidden;

    min-height:
        155px;

    padding:
        25px;

    background:
        rgba(255,255,255,.88);

    border:
        1px solid var(--border);

    border-radius:
        24px;

    box-shadow:
        var(--shadow);

    transition:
        all .3s ease;

}


.stat-card:hover {

    transform:
        translateY(-5px);

    box-shadow:
        var(--shadow-hover);

}


/*
   Decorative circle
*/

.stat-card::after {

    content:
        "";

    position:
        absolute;

    width:
        105px;

    height:
        105px;

    right:
        -32px;

    bottom:
        -38px;

    border-radius:
        50%;

    opacity:
        .8;

}


.stat-card:nth-child(1)::after {

    background:
        var(--yellow-soft);

}


.stat-card:nth-child(2)::after {

    background:
        var(--green-soft);

}


.stat-card:nth-child(3)::after {

    background:
        var(--blue-soft);

}


.stat-card:nth-child(4)::after {

    background:
        var(--brown-soft);

}


/*
   Icons
*/

.stat-card::before {

    position:
        absolute;

    right:
        20px;

    top:
        20px;

    font-size:
        28px;

    z-index:
        3;

}


.stat-card:nth-child(1)::before {

    content:
        "📚";

}


.stat-card:nth-child(2)::before {

    content:
        "🌿";

}


.stat-card:nth-child(3)::before {

    content:
        "✍️";

}


.stat-card:nth-child(4)::before {

    content:
        "☀️";

}


.stat-label {

    position:
        relative;

    z-index:
        4;

    display:
        block;

    margin-bottom:
        14px;

    color:
        var(--text-soft);

    font-size:
        11px;

    font-weight:
        800;

    letter-spacing:
        1px;

}


.stat-value {

    position:
        relative;

    z-index:
        4;

    display:
        block;

    color:
        var(--brown-dark);

    font-family:
        Georgia,
        "Times New Roman",
        serif;

    font-size:
        36px;

    font-weight:
        800;

}


/* =====================================================
   CHART
===================================================== */

.chart-card {

    position:
        relative;

    overflow:
        hidden;

    margin-bottom:
        25px;

    padding:
        30px;

    background:
        rgba(255,255,255,.90);

    border:
        1px solid var(--border);

    border-radius:
        28px;

    box-shadow:
        var(--shadow);

}


.chart-card::before {

    content:
        "🌿";

    position:
        absolute;

    right:
        25px;

    top:
        18px;

    font-size:
        32px;

    opacity:
        .45;

}


.chart-card h2 {

    margin:
        0 0 25px;

    color:
        var(--brown-dark);

    font-family:
        Georgia,
        "Times New Roman",
        serif;

    font-size:
        21px;

}


/* =====================================================
   BUTTON
===================================================== */

.dashboard-action {

    display:
        flex;

    justify-content:
        flex-end;

}


.btn {

    display:
        inline-flex;

    align-items:
        center;

    gap:
        9px;

    padding:
        13px 22px;

    color:
        #FFFFFF !important;

    background:
        var(--green-dark);

    border:
        none;

    border-radius:
        30px;

    text-decoration:
        none;

    font-weight:
        700;

    font-size:
        14px;

    box-shadow:
        0 8px 18px rgba(111,146,112,.22);

    transition:
        all .25s ease;

}


.btn:hover {

    background:
        var(--brown);

    transform:
        translateY(-3px);

    box-shadow:
        0 12px 24px rgba(95,70,53,.20);

}


/* =====================================================
   CHART CANVAS
===================================================== */

#grafikKategori {

    max-height:
        350px;

}


/* =====================================================
   DARK MODE
===================================================== */

body.dark-mode,
body.dark {

    background:
        radial-gradient(
            circle at 10% 10%,
            rgba(243,216,139,.08),
            transparent 25%
        ),

        radial-gradient(
            circle at 90% 20%,
            rgba(157,184,155,.08),
            transparent 25%
        ),

        #202923 !important;

    color:
        #E9E5D9 !important;

}


/* =====================================================
   DARK NAVBAR
===================================================== */

body.dark-mode nav,
body.dark-mode header,
body.dark-mode .navbar,
body.dark nav,
body.dark header,
body.dark .navbar {

    background:
        rgba(30,39,34,.96) !important;

    color:
        #F4F0E5 !important;

    border-bottom:
        1px solid #435047 !important;

    box-shadow:
        0 6px 20px rgba(0,0,0,.25) !important;

}


body.dark-mode nav a,
body.dark-mode header a,
body.dark-mode .navbar a,
body.dark nav a,
body.dark header a,
body.dark .navbar a {

    color:
        #E7E4D9 !important;

}


body.dark-mode nav a:hover,
body.dark-mode header a:hover,
body.dark-mode .navbar a:hover,
body.dark nav a:hover,
body.dark header a:hover,
body.dark .navbar a:hover {

    background:
        #35443A !important;

    color:
        #C6DDBF !important;

}


body.dark-mode nav button,
body.dark-mode header button,
body.dark-mode .navbar button,
body.dark nav button,
body.dark header button,
body.dark .navbar button {

    background:
        #2D3931 !important;

    color:
        #F4F0E5 !important;

    border:
        1px solid #4A584E !important;

}


/* =====================================================
   DARK HERO
===================================================== */

body.dark-mode .dashboard-header,
body.dark .dashboard-header {

    background:

        linear-gradient(
            135deg,
            #2C3931,
            #3A382D,
            #304044
        ) !important;

    border:
        1px solid #4B574E !important;

    box-shadow:
        0 15px 35px rgba(0,0,0,.25);

}


body.dark-mode .dashboard-header::before,
body.dark .dashboard-header::before {

    background:
        rgba(243,216,139,.10);

}


body.dark-mode .dashboard-header::after,
body.dark .dashboard-header::after {

    background:
        rgba(255,255,255,.04);

    border-color:
        rgba(255,255,255,.08);

}


body.dark-mode .welcome-badge,
body.dark .welcome-badge {

    background:
        rgba(44,57,49,.90);

    color:
        #C6DDBF;

    border-color:
        #536157;

}


body.dark-mode .dashboard-header h1,
body.dark .dashboard-header h1 {

    color:
        #FFF8E8 !important;

}


body.dark-mode .dashboard-header p,
body.dark .dashboard-header p {

    color:
        #C2C6BB !important;

}


/* =====================================================
   DARK STATISTICS
===================================================== */

body.dark-mode .stat-card,
body.dark .stat-card {

    background:
        #29352E !important;

    border:
        1px solid #465249 !important;

    box-shadow:
        0 12px 30px rgba(0,0,0,.22);

}


body.dark-mode .stat-card:hover,
body.dark .stat-card:hover {

    background:
        #303D34 !important;

    border-color:
        #5B695F !important;

}


body.dark-mode .stat-label,
body.dark .stat-label {

    color:
        #BFC5BA !important;

}


body.dark-mode .stat-value,
body.dark .stat-value {

    color:
        #FFF7E5 !important;

}


body.dark-mode .stat-card:nth-child(1)::after,
body.dark .stat-card:nth-child(1)::after {

    background:
        #9A8752;

    opacity:
        .20;

}


body.dark-mode .stat-card:nth-child(2)::after,
body.dark .stat-card:nth-child(2)::after {

    background:
        #769274;

    opacity:
        .20;

}


body.dark-mode .stat-card:nth-child(3)::after,
body.dark .stat-card:nth-child(3)::after {

    background:
        #6F8F95;

    opacity:
        .20;

}


body.dark-mode .stat-card:nth-child(4)::after,
body.dark .stat-card:nth-child(4)::after {

    background:
        #85694F;

    opacity:
        .20;

}


/* =====================================================
   DARK CHART
===================================================== */

body.dark-mode .chart-card,
body.dark .chart-card {

    background:
        #29352E !important;

    border:
        1px solid #465249 !important;

    box-shadow:
        0 15px 35px rgba(0,0,0,.25);

}


body.dark-mode .chart-card h2,
body.dark .chart-card h2 {

    color:
        #FFF7E5 !important;

}


/* =====================================================
   DARK BUTTON
===================================================== */

body.dark-mode .btn,
body.dark .btn {

    background:
        #789878 !important;

    color:
        #FFFFFF !important;

}


body.dark-mode .btn:hover,
body.dark .btn:hover {

    background:
        #9A795C !important;

}


/* =====================================================
   RESPONSIVE
===================================================== */

@media (max-width: 900px) {

    .stat-grid {

        grid-template-columns:
            repeat(2, 1fr);

    }

}


@media (max-width: 600px) {

    .container {

        width:
            94%;

        margin-top:
            20px;

    }


    .dashboard-header {

        padding:
            30px 23px;

        min-height:
            250px;

        border-radius:
            24px;

    }


    .dashboard-header h1 {

        font-size:
            29px;

    }


    .dashboard-header h1::before {

        display:
            none;

    }


    .dashboard-header::after {

        right:
            -35px;

        opacity:
            .35;

    }


    .stat-grid {

        grid-template-columns:
            1fr;

    }


    .chart-card {

        padding:
            20px;

        border-radius:
            23px;

    }


    .dashboard-action {

        justify-content:
            center;

    }


    .btn {

        width:
            100%;

        justify-content:
            center;

    }

}

</style>

</head>


<body>


<?php include 'includes/navbar.php'; ?>


<main class="container">


    <!-- =================================================
         HEADER
    ================================================== -->

    <section class="dashboard-header">

        <div class="welcome-badge">

            Dashboard Perpustakaan

        </div>


        <h1>

            Halo, Admin! 👋📚

        </h1>


        <p>

            Selamat datang di ruang perpustakaan.
            Kelola koleksi buku dan pantau data
            perpustakaan dengan nyaman.

        </p>

    </section>



    <!-- =================================================
         STATISTIK
    ================================================== -->

    <div class="stat-grid">


        <div class="stat-card">

            <span class="stat-label">

                TOTAL BUKU

            </span>


            <span class="stat-value">

                <?= (int)$totalBuku ?>

            </span>

        </div>



        <div class="stat-card">

            <span class="stat-label">

                KATEGORI

            </span>


            <span class="stat-value">

                <?= (int)$jumlahKategori ?>

            </span>

        </div>



        <div class="stat-card">

            <span class="stat-label">

                DATA PENULIS

            </span>


            <span class="stat-value">

                <?= (int)$jumlahPenulis ?>

            </span>

        </div>



        <div class="stat-card">

            <span class="stat-label">

                TERBIT TERBARU

            </span>


            <span class="stat-value">

                <?= htmlspecialchars($tahunTerbaru ?? '-') ?>

            </span>

        </div>


    </div>



    <!-- =================================================
         GRAFIK
    ================================================== -->

    <div class="chart-card">

        <h2>

            📚 Koleksi Buku Berdasarkan Kategori

        </h2>


        <canvas
            id="grafikKategori"
            height="110">
        </canvas>

    </div>



    <!-- =================================================
         BUTTON
    ================================================== -->

    <div class="dashboard-action">

        <a
            href="data_buku.php"
            class="btn">

            📖 Jelajahi Data Buku →

        </a>

    </div>


</main>



<script>

/* =====================================================
   CHART
===================================================== */

const ctx =
    document.getElementById('grafikKategori');


const chart =
    new Chart(ctx, {

        type:
            'bar',


        data: {

            labels:
                <?= json_encode(
                    $labelKategori,
                    JSON_UNESCAPED_UNICODE
                ) ?>,


            datasets: [{

                label:
                    'Jumlah Buku',


                data:
                    <?= json_encode(
                        $jumlahPerKategori
                    ) ?>,


                backgroundColor:
                    '#9DB89B',


                borderColor:
                    '#6F9270',


                borderWidth:
                    1,


                borderRadius:
                    10,


                borderSkipped:
                    false

            }]

        },


        options: {

            responsive:
                true,


            maintainAspectRatio:
                false,


            plugins: {

                legend: {

                    display:
                        false

                }

            },


            scales: {

                y: {

                    beginAtZero:
                        true,


                    ticks: {

                        stepSize:
                            1,

                        color:
                            '#777568'

                    },


                    grid: {

                        color:
                            '#EDE5D8'

                    }

                },


                x: {

                    ticks: {

                        color:
                            '#777568'

                    },


                    grid: {

                        display:
                            false

                    }

                }

            }

        }

    });


/* =====================================================
   DARK MODE CHART
===================================================== */

function updateChartTheme() {

    const dark =
        document.body.classList.contains('dark-mode') ||
        document.body.classList.contains('dark');


    if (dark) {

        chart.options.scales.y.ticks.color =
            '#C2C6BB';

        chart.options.scales.x.ticks.color =
            '#C2C6BB';

        chart.options.scales.y.grid.color =
            '#435047';

        chart.data.datasets[0].backgroundColor =
            '#789878';

        chart.data.datasets[0].borderColor =
            '#9DB89B';

    } else {

        chart.options.scales.y.ticks.color =
            '#777568';

        chart.options.scales.x.ticks.color =
            '#777568';

        chart.options.scales.y.grid.color =
            '#EDE5D8';

        chart.data.datasets[0].backgroundColor =
            '#9DB89B';

        chart.data.datasets[0].borderColor =
            '#6F9270';

    }


    chart.update();

}


updateChartTheme();


/*
   Memantau perubahan dark mode
*/

new MutationObserver(
    updateChartTheme
).observe(
    document.body,
    {
        attributes: true,
        attributeFilter: ['class']
    }
);

</script>


</body>

</html>