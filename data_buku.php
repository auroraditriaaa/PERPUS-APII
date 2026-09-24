<?php require_once 'includes/auth.php'; ?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Data Buku - Perpus API</title>

<link rel="stylesheet" href="style.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.5/sweetalert2.all.min.js"></script>


<style>

/* =====================================================
   COZY WHIMSICAL LIBRARY
   DATA BUKU
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
        0 12px 30px rgba(91, 72, 52, .10);

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
            circle at 5% 10%,
            rgba(241,213,130,.22),
            transparent 22%
        ),

        radial-gradient(
            circle at 95% 15%,
            rgba(169,201,207,.25),
            transparent 25%
        ),

        var(--cream);

    color:
        var(--text);

}


/* =====================================================
   NAVBAR
===================================================== */

body > nav {

    background:
        rgba(255, 253, 247, .97) !important;

    color:
        var(--brown-dark) !important;

    border-bottom:
        1px solid var(--border) !important;

    box-shadow:
        0 5px 18px rgba(91,72,52,.08) !important;

}


body > nav a {

    color:
        var(--brown-dark) !important;

    text-decoration:
        none !important;

    transition:
        all .25s ease;

}


body > nav a:hover {

    color:
        var(--green-dark) !important;

}


body > nav a:first-child {

    color:
        var(--brown-dark) !important;

    font-weight:
        900;

}


body > nav a.active {

    color:
        var(--green-dark) !important;

}


body > nav button {

    background:
        var(--yellow-light) !important;

    color:
        var(--brown-dark) !important;

    border:
        1px solid var(--border) !important;

    border-radius:
        12px !important;

    transition:
        all .25s ease;

}


body > nav button:hover {

    background:
        var(--green-light) !important;

    color:
        var(--brown-dark) !important;

    transform:
        translateY(-2px);

}


body > nav a[href*="logout"] {

    color:
        #9a604d !important;

}


body > nav a[href*="logout"]:hover {

    color:
        #d98570 !important;

}


/* =====================================================
   NAVBAR CLASS OVERRIDE
===================================================== */

.navbar,
.navbar-container {

    background:
        rgba(255, 253, 247, .97) !important;

    border-bottom:
        1px solid var(--border) !important;

    box-shadow:
        0 5px 18px rgba(91,72,52,.08) !important;

}


.navbar a,
.navbar-container a {

    color:
        var(--brown-dark) !important;

}


.navbar a:hover,
.navbar-container a:hover {

    color:
        var(--green-dark) !important;

}


/* =====================================================
   CONTAINER
===================================================== */

.container {

    width:
        min(1200px, 92%);

    margin:
        38px auto 70px;

}


/* =====================================================
   PAGE HEADER
===================================================== */

.container > h1 {

    position:
        relative;

    overflow:
        hidden;

    margin:
        0 0 24px;

    padding:
        32px 35px;

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


/* Decorative sunlight */

.container > h1::before {

    content:
        "☀️";

    position:
        absolute;

    right:
        40px;

    top:
        15px;

    font-family:
        Arial,
        sans-serif;

    font-size:
        52px;

    opacity:
        .30;

}


/* Decorative books */

.container > h1::after {

    content:
        "📚";

    position:
        absolute;

    right:
        105px;

    bottom:
        10px;

    font-family:
        Arial,
        sans-serif;

    font-size:
        35px;

    opacity:
        .30;

}


/* =====================================================
   TOOLBAR
===================================================== */

.toolbar {

    display:
        flex;

    align-items:
        center;

    gap:
        12px;

    flex-wrap:
        wrap;

    padding:
        16px;

    margin-bottom:
        13px;

    background:
        rgba(255,255,255,.88);

    border:
        1px solid var(--border);

    border-radius:
        21px;

    box-shadow:
        0 8px 22px rgba(91,72,52,.07);

}


/* =====================================================
   SEARCH
===================================================== */

#cariBuku {

    flex:
        1;

    min-width:
        280px;

    height:
        46px;

    padding:
        0 18px;

    border:
        1px solid var(--border);

    border-radius:
        16px;

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


#cariBuku::placeholder {

    color:
        #aaa194;

}


#cariBuku:focus {

    background:
        #ffffff;

    border-color:
        var(--green);

    box-shadow:
        0 0 0 4px rgba(155,185,155,.18);

}


/* =====================================================
   FILTER KATEGORI
===================================================== */

#filterKategori {

    min-width:
        190px;

    height:
        46px;

    padding:
        0 15px;

    border:
        1px solid var(--border);

    border-radius:
        16px;

    outline:
        none;

    background:
        var(--cream-light);

    color:
        var(--brown-dark);

    font-family:
        inherit;

    font-size:
        14px;

    cursor:
        pointer;

}


#filterKategori:focus {

    border-color:
        var(--green);

    box-shadow:
        0 0 0 4px rgba(155,185,155,.18);

}


/* =====================================================
   BUTTON
===================================================== */

.btn {

    display:
        inline-flex;

    align-items:
        center;

    justify-content:
        center;

    min-height:
        44px;

    padding:
        0 19px;

    border:
        none;

    border-radius:
        17px;

    text-decoration:
        none;

    font-family:
        inherit;

    font-size:
        13px;

    font-weight:
        800;

    cursor:
        pointer;

    transition:
        all .25s ease;

}


/* Tambah */

.btn-tambah {

    background:
        var(--green-dark);

    color:
        white !important;

    box-shadow:
        0 7px 17px rgba(111,145,111,.22);

}


.btn-tambah:hover {

    background:
        var(--brown);

    transform:
        translateY(-2px);

}


/* =====================================================
   EXPORT
===================================================== */

.toolbar-export {

    justify-content:
        flex-end;

    background:
        transparent;

    border:
        none;

    box-shadow:
        none;

    padding:
        4px 3px;

}


.toolbar-label {

    color:
        var(--text-soft);

    font-size:
        13px;

}


.btn-secondary {

    min-height:
        37px;

    padding:
        0 14px;

    background:
        var(--blue-light);

    color:
        #55777d !important;

    border:
        1px solid #d2e4e6;

    border-radius:
        13px;

}


.btn-secondary:hover {

    background:
        var(--yellow-light);

    color:
        var(--brown-dark) !important;

    transform:
        translateY(-2px);

}


.btn-sm {

    font-size:
        12px;

}


/* =====================================================
   TABLE
===================================================== */

.table-wrap {

    width:
        100%;

    overflow-x:
        auto;

    background:
        rgba(255,255,255,.94);

    border:
        1px solid var(--border);

    border-radius:
        25px;

    box-shadow:
        var(--shadow);

}


.data-table {

    width:
        100%;

    min-width:
        950px;

    border-collapse:
        collapse;

}


/* =====================================================
   TABLE HEADER
===================================================== */

.data-table thead {

    background:
        var(--green-light);

}


.data-table th {

    padding:
        17px 14px;

    color:
        var(--brown-dark);

    font-size:
        11px;

    font-weight:
        900;

    letter-spacing:
        .6px;

    text-align:
        left;

    white-space:
        nowrap;

    border-bottom:
        1px solid var(--border);

}


.data-table th:first-child {

    border-radius:
        24px 0 0 0;

}


.data-table th:last-child {

    border-radius:
        0 24px 0 0;

}


/* =====================================================
   SORT
===================================================== */

.data-table th.sortable {

    cursor:
        pointer;

    user-select:
        none;

}


.data-table th.sortable:hover {

    background:
        var(--yellow-light);

}


#panahSort {

    display:
        inline-flex;

    align-items:
        center;

    justify-content:
        center;

    width:
        22px;

    height:
        22px;

    margin-left:
        3px;

    border-radius:
        50%;

    background:
        white;

    color:
        var(--green-dark);

}


/* =====================================================
   TABLE BODY
===================================================== */

.data-table td {

    padding:
        15px 14px;

    border-bottom:
        1px solid #eee7dc;

    color:
        var(--text-soft);

    font-size:
        13px;

}


.data-table tbody tr {

    background:
        rgba(255,255,255,.65);

    transition:
        all .2s ease;

}


.data-table tbody tr:hover {

    background:
        #fff8df;

}


.data-table tbody tr:last-child td {

    border-bottom:
        none;

}


/* =====================================================
   TABLE CONTENT
===================================================== */

.data-table td:first-child {

    color:
        var(--brown);

    font-weight:
        800;

}


.data-table td:nth-child(2) {

    color:
        var(--green-dark);

    font-weight:
        800;

}


.data-table td:nth-child(3) {

    color:
        var(--brown-dark);

    font-weight:
        800;

}


.data-table td:nth-child(5) {

    color:
        var(--green-dark);

    font-weight:
        700;

}


.data-table td:nth-child(6) {

    color:
        var(--brown);

    font-weight:
        700;

}


/* =====================================================
   ACTION
===================================================== */

.aksi {

    display:
        flex;

    align-items:
        center;

    gap:
        7px;

    white-space:
        nowrap;

}


.btn-kecil {

    display:
        inline-flex;

    align-items:
        center;

    justify-content:
        center;

    min-width:
        58px;

    height:
        32px;

    padding:
        0 10px;

    border-radius:
        11px;

    text-decoration:
        none;

    font-size:
        10px;

    font-weight:
        900;

    transition:
        all .2s ease;

}


/* EDIT */

.aksi .btn-kecil:not(.btn-hapus) {

    background:
        var(--blue-light);

    color:
        #52747a;

    border:
        1px solid #d2e4e6;

}


.aksi .btn-kecil:not(.btn-hapus):hover {

    background:
        var(--blue);

    color:
        white;

    transform:
        translateY(-2px);

}


/* DELETE */

.btn-hapus {

    background:
        #f8e5dd;

    color:
        #9a604d;

    border:
        1px solid #ecd2c8;

}


.btn-hapus:hover {

    background:
        #d98570;

    color:
        white;

    transform:
        translateY(-2px);

}


/* =====================================================
   PAGINATION
===================================================== */

.pagination {

    display:
        flex;

    align-items:
        center;

    justify-content:
        center;

    gap:
        11px;

    margin-top:
        22px;

}


.pagination button {

    min-height:
        38px;

    padding:
        0 15px;

    border:
        1px solid var(--border);

    border-radius:
        14px;

    background:
        white;

    color:
        var(--brown-dark);

    font-family:
        inherit;

    font-size:
        12px;

    font-weight:
        800;

    cursor:
        pointer;

    transition:
        all .2s ease;

}


.pagination button:hover:not(:disabled) {

    background:
        var(--green-light);

    border-color:
        var(--green);

    transform:
        translateY(-2px);

}


.pagination button:disabled {

    opacity:
        .45;

    cursor:
        not-allowed;

}


.pagi-info {

    padding:
        9px 15px;

    border:
        1px solid #f0dda8;

    border-radius:
        14px;

    background:
        var(--yellow-light);

    color:
        var(--brown-dark);

    font-size:
        12px;

    font-weight:
        800;

}


/* =====================================================
   LOADING / EMPTY
===================================================== */

.data-table td[colspan] {

    padding:
        45px 20px;

    text-align:
        center;

    color:
        #9b9588;

    font-style:
        italic;

}


/* =====================================================
   SWEET ALERT
===================================================== */

.swal2-popup {

    border-radius:
        25px !important;

    border:
        1px solid var(--border) !important;

    font-family:
        "Trebuchet MS",
        "Segoe UI",
        sans-serif !important;

}


.swal2-title {

    color:
        var(--brown-dark) !important;

}


.swal2-html-container {

    color:
        var(--text-soft) !important;

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


/* Navbar dark */

body.dark-mode > nav,
body.dark > nav {

    background:
        #29352e !important;

    color:
        #eee9dc !important;

    border-bottom-color:
        #465249 !important;

    box-shadow:
        0 5px 20px rgba(0,0,0,.20) !important;

}


body.dark-mode > nav a,
body.dark > nav a {

    color:
        #eee9dc !important;

}


body.dark-mode > nav a:hover,
body.dark > nav a:hover {

    color:
        #b7d0b2 !important;

}


body.dark-mode > nav button,
body.dark > nav button {

    background:
        #3b463d !important;

    color:
        #f1dfc0 !important;

    border-color:
        #526057 !important;

}


body.dark-mode > nav a[href*="logout"],
body.dark > nav a[href*="logout"] {

    color:
        #e8a895 !important;

}


/* Header */

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


/* Toolbar */

body.dark-mode .toolbar,
body.dark .toolbar {

    background:
        #29352e !important;

    border-color:
        #465249 !important;

}


body.dark-mode #cariBuku,
body.dark #cariBuku,
body.dark-mode #filterKategori,
body.dark #filterKategori {

    background:
        #202923 !important;

    color:
        #f2eee2 !important;

    border-color:
        #526057 !important;

}


body.dark-mode #cariBuku::placeholder,
body.dark #cariBuku::placeholder {

    color:
        #909990;

}


body.dark-mode .toolbar-label,
body.dark .toolbar-label {

    color:
        #c0c5bb;

}


/* Table */

body.dark-mode .table-wrap,
body.dark .table-wrap {

    background:
        #29352e !important;

    border-color:
        #465249 !important;

}


body.dark-mode .data-table thead,
body.dark .data-table thead {

    background:
        #35443a !important;

}


body.dark-mode .data-table th,
body.dark .data-table th {

    color:
        #f1ebdc !important;

    border-bottom-color:
        #4a574e !important;

}


body.dark-mode .data-table td,
body.dark .data-table td {

    color:
        #c2c6bb !important;

    border-bottom-color:
        #3d4941 !important;

}


body.dark-mode .data-table tbody tr,
body.dark .data-table tbody tr {

    background:
        #29352e !important;

}


body.dark-mode .data-table tbody tr:hover,
body.dark .data-table tbody tr:hover {

    background:
        #344139 !important;

}


/* Text colors */

body.dark-mode .data-table td:nth-child(2),
body.dark .data-table td:nth-child(2),
body.dark-mode .data-table td:nth-child(5),
body.dark .data-table td:nth-child(5) {

    color:
        #b7d0b2 !important;

}


body.dark-mode .data-table td:nth-child(3),
body.dark .data-table td:nth-child(3),
body.dark-mode .data-table td:nth-child(6),
body.dark .data-table td:nth-child(6) {

    color:
        #f1dfc0 !important;

}


/* Action */

body.dark-mode .aksi .btn-kecil:not(.btn-hapus),
body.dark .aksi .btn-kecil:not(.btn-hapus) {

    background:
        #35484a;

    color:
        #c8dfe1;

    border-color:
        #506568;

}


body.dark-mode .btn-hapus,
body.dark .btn-hapus {

    background:
        #4a3731;

    color:
        #e8a895;

    border-color:
        #67483f;

}


/* Pagination */

body.dark-mode .pagination button,
body.dark .pagination button {

    background:
        #29352e;

    color:
        #eee9dc;

    border-color:
        #4b574e;

}


body.dark-mode .pagi-info,
body.dark .pagi-info {

    background:
        #4a432f;

    color:
        #f1dfc0;

    border-color:
        #6b5f3d;

}


/* =====================================================
   RESPONSIVE
===================================================== */

@media (max-width: 700px) {

    .container {

        width:
            94%;

        margin-top:
            22px;

    }


    .container > h1 {

        padding:
            25px 22px;

        font-size:
            25px;

        border-radius:
            22px;

    }


    .container > h1::before {

        right:
            20px;

        font-size:
            38px;

    }


    .container > h1::after {

        right:
            65px;

        font-size:
            27px;

    }


    .toolbar {

        padding:
            14px;

    }


    #cariBuku {

        width:
            100%;

        min-width:
            100%;

    }


    #filterKategori {

        width:
            100%;

    }


    .btn-tambah {

        width:
            100%;

    }


    .toolbar-export {

        justify-content:
            flex-start;

    }


    .toolbar-label {

        width:
            100%;

    }


    .table-wrap {

        border-radius:
            20px;

    }


    .pagination {

        flex-wrap:
            wrap;

    }


    body > nav {

        overflow-x:
            auto;

    }

}


/* =====================================================
   EXTRA NAVBAR OVERRIDE
===================================================== */

header,
.navbar,
.navbar-container {

    background:
        rgba(255,253,247,.97) !important;

    border-bottom:
        1px solid var(--border) !important;

    box-shadow:
        0 5px 18px rgba(91,72,52,.08) !important;

}


header a,
.navbar a,
.navbar-container a {

    color:
        var(--brown-dark) !important;

}


header a:hover,
.navbar a:hover,
.navbar-container a:hover {

    color:
        var(--green-dark) !important;

}


body.dark-mode header,
body.dark .navbar,
body.dark .navbar-container {

    background:
        #29352e !important;

    border-bottom-color:
        #465249 !important;

}


body.dark-mode header a,
body.dark .navbar a,
body.dark .navbar-container a {

    color:
        #eee9dc !important;

}


body.dark-mode header a:hover,
body.dark .navbar a:hover,
body.dark .navbar-container a:hover {

    color:
        #b7d0b2 !important;

}

</style>

</head>


<body>


<?php include 'includes/navbar.php'; ?>


<main class="container">


    <!-- =================================================
         JUDUL
    ================================================== -->

    <h1>
        Data Buku Perpustakaan
    </h1>


    <!-- =================================================
         SEARCH & FILTER
    ================================================== -->

    <div class="toolbar">

        <input
            type="text"
            id="cariBuku"
            placeholder="Cari kode / judul / penulis / penerbit..."
        >


        <select id="filterKategori">

            <option value="">
                Semua Kategori
            </option>

        </select>


        <a
            href="tambah.php"
            class="btn btn-tambah"
        >
            + Tambah Buku
        </a>

    </div>


    <!-- =================================================
         EXPORT
    ================================================== -->

    <div class="toolbar toolbar-export">

        <span class="toolbar-label">
            Export hasil pencarian saat ini:
        </span>


        <a
            href="#"
            id="linkExportExcel"
            class="btn btn-secondary btn-sm"
        >
            ⬇ Excel
        </a>


        <a
            href="#"
            id="linkExportPdf"
            class="btn btn-secondary btn-sm"
        >
            ⬇ PDF
        </a>

    </div>


    <!-- =================================================
         TABLE
    ================================================== -->

    <div class="table-wrap">

        <table class="data-table">

            <thead>

                <tr>

                    <th>NO / ID</th>

                    <th>KODE BUKU</th>

                    <th>JUDUL</th>

                    <th>PENULIS</th>

                    <th>KATEGORI</th>

                    <th
                        id="thTahun"
                        class="sortable"
                    >

                        TAHUN TERBIT

                        <span id="panahSort">
                            ↕
                        </span>

                    </th>

                    <th>PENERBIT</th>

                    <th>AKSI</th>

                </tr>

            </thead>


            <tbody id="isiTabel">

                <tr>

                    <td colspan="8">
                        Memuat data...
                    </td>

                </tr>

            </tbody>

        </table>

    </div>


    <!-- =================================================
         PAGINATION
    ================================================== -->

    <div
        class="pagination"
        id="paginasi"
    ></div>


</main>


<script>

let semuaBuku = [];

let dataTampil = [];

let arahSort = null;

let halamanAktif = 1;

const PER_HALAMAN = 5;


/* =========================================
   AMBIL DATA DARI API
========================================= */

fetch("data_json.php")

    .then(response => {

        if (!response.ok) {

            throw new Error(
                "Gagal mengambil data dari server."
            );

        }

        return response.json();

    })

    .then(data => {

        semuaBuku = Array.isArray(data)
            ? data
            : [];

        isiPilihanKategori(data);

        terapkanFilter();

    })

    .catch(err => {

        document.getElementById("isiTabel").innerHTML =

            "<tr>" +
                "<td colspan='8'>" +
                    "Gagal memuat data dari API." +
                "</td>" +
            "</tr>";

        console.error(err);

    });


/* =========================================
   PILIHAN KATEGORI
========================================= */

function isiPilihanKategori(data) {

    const select =
        document.getElementById("filterKategori");

    const kategoriUnik = [

        ...new Set(

            data

                .map(b => b.kategori || "")

                .filter(k => k !== "")

        )

    ].sort();


    kategoriUnik.forEach(k => {

        const opt =
            document.createElement("option");

        opt.value = k;

        opt.textContent = k;

        select.appendChild(opt);

    });

}


/* =========================================
   SECURITY HTML
========================================= */

function escapeHTML(str) {

    const div =
        document.createElement("div");

    div.textContent =
        String(str ?? "");

    return div.innerHTML;

}


/* =========================================
   TAMPILKAN DATA
========================================= */

function tampilkanData(data) {

    const tbody =
        document.getElementById("isiTabel");


    if (data.length === 0) {

        tbody.innerHTML =

            "<tr>" +
                "<td colspan='8'>" +
                    "Tidak ada data ditemukan." +
                "</td>" +
            "</tr>";

        document.getElementById(
            "paginasi"
        ).innerHTML = "";

        return;

    }


    const totalHalaman =

        Math.max(
            1,
            Math.ceil(
                data.length / PER_HALAMAN
            )
        );


    if (halamanAktif > totalHalaman) {

        halamanAktif =
            totalHalaman;

    }


    const mulai =

        (halamanAktif - 1) *
        PER_HALAMAN;


    const potongan =

        data.slice(
            mulai,
            mulai + PER_HALAMAN
        );


    tbody.innerHTML =

        potongan.map((b, i) => `

            <tr>

                <td>
                    ${mulai + i + 1}
                </td>


                <td>
                    ${escapeHTML(b.kode_buku)}
                </td>


                <td>
                    ${escapeHTML(b.judul)}
                </td>


                <td>
                    ${escapeHTML(b.penulis)}
                </td>


                <td>
                    ${escapeHTML(b.kategori)}
                </td>


                <td>
                    ${escapeHTML(
                        String(b.tahun_terbit)
                    )}
                </td>


                <td>
                    ${escapeHTML(b.penerbit)}
                </td>


                <td class="aksi">

                    <a
                        href="edit.php?id=${encodeURIComponent(b.id)}"
                        class="btn-kecil"
                    >
                        EDIT
                    </a>


                    <a
                        href="#"
                        class="btn-kecil btn-hapus"
                        onclick="hapusBuku(
                            ${Number(b.id)},
                            '${escapeHTML(
                                b.judul
                            ).replace(/'/g, "\\'")}'
                        ); return false;"
                    >
                        HAPUS
                    </a>

                </td>

            </tr>

        `).join("");


    renderPaginasi(totalHalaman);

}


/* =========================================
   PAGINATION
========================================= */

function renderPaginasi(totalHalaman) {

    const wrap =
        document.getElementById(
            "paginasi"
        );


    if (totalHalaman <= 1) {

        wrap.innerHTML = "";

        return;

    }


    let html = `

        <button
            ${halamanAktif === 1
                ? "disabled"
                : ""
            }

            onclick="gantiHalaman(
                ${halamanAktif - 1}
            )"
        >

            &laquo; Sebelumnya

        </button>

    `;


    html += `

        <span class="pagi-info">

            Halaman
            ${halamanAktif}
            dari
            ${totalHalaman}

        </span>

    `;


    html += `

        <button
            ${halamanAktif === totalHalaman
                ? "disabled"
                : ""
            }

            onclick="gantiHalaman(
                ${halamanAktif + 1}
            )"
        >

            Berikutnya &raquo;

        </button>

    `;


    wrap.innerHTML =
        html;

}


/* =========================================
   GANTI HALAMAN
========================================= */

function gantiHalaman(h) {

    halamanAktif =
        h;

    tampilkanData(
        dataTampil
    );

}


/* =========================================
   HAPUS BUKU
========================================= */

function hapusBuku(id, judul) {

    Swal.fire({

        title:
            "Hapus buku ini?",

        text:
            `"${judul}" akan dihapus permanen dari database.`,

        icon:
            "warning",

        showCancelButton:
            true,

        confirmButtonText:
            "Ya, hapus",

        cancelButtonText:
            "Batal",

        confirmButtonColor:
            "#8b6b4f"

    })

    .then(result => {

        if (result.isConfirmed) {

            window.location.href =
                "hapus.php?id=" +
                encodeURIComponent(id);

        }

    });

}


/* =========================================
   FILTER
========================================= */

function terapkanFilter() {

    const kata =

        document
            .getElementById("cariBuku")
            .value
            .trim()
            .toLowerCase();


    const kategori =

        document
            .getElementById("filterKategori")
            .value;


    let hasil =

        semuaBuku.filter(b => {

            /*
             * PENCARIAN:
             * 1. KODE BUKU
             * 2. JUDUL
             * 3. PENULIS
             * 4. PENERBIT
             */

            const kode =
                String(
                    b.kode_buku ?? ""
                ).toLowerCase();

            const judul =
                String(
                    b.judul ?? ""
                ).toLowerCase();

            const penulis =
                String(
                    b.penulis ?? ""
                ).toLowerCase();

            const penerbit =
                String(
                    b.penerbit ?? ""
                ).toLowerCase();


            const cocokKata =

                b.judul
                    .toLowerCase()
                    .includes(kata)

                ||

                b.penulis
                    .toLowerCase()
                    .includes(kata)

                ||

                b.kode_buku
                    .toLowerCase()
                    .includes(kata)

                ||

                b.penerbit
                    .toLowerCase()
                    .includes(kata);


            const cocokKategori =

                kategori === "" ||

                String(
                    b.kategori ?? ""
                ) === kategori;


            return (
                cocokKata &&
                cocokKategori
            );

        });


    /* =====================================
       SORTING TAHUN
    ===================================== */

    if (arahSort === "asc") {

        hasil =

            [...hasil].sort(
                (a, b) =>
                    Number(a.tahun_terbit) -
                    Number(b.tahun_terbit)
            );

    }


    if (arahSort === "desc") {

        hasil =

            [...hasil].sort(
                (a, b) =>
                    Number(b.tahun_terbit) -
                    Number(a.tahun_terbit)
            );

    }


    dataTampil =
        hasil;


    halamanAktif =
        1;


    tampilkanData(
        hasil
    );


    perbaruiLinkExport(
        kata,
        kategori
    );

}


/* =========================================
   LINK EXPORT
========================================= */

function perbaruiLinkExport(
    kata,
    kategori
) {

    const params =
        new URLSearchParams();


    if (kata) {

        params.set(
            "cari",
            kata
        );

    }


    if (kategori) {

        params.set(
            "kategori",
            kategori
        );

    }


    document.getElementById(
        "linkExportExcel"
    ).href =

        "export_excel.php?" +
        params.toString();


    document.getElementById(
        "linkExportPdf"
    ).href =

        "export_pdf.php?" +
        params.toString();

}


/* =========================================
   EVENT SEARCH
========================================= */

document
    .getElementById("cariBuku")
    .addEventListener(
        "input",
        terapkanFilter
    );


/* =========================================
   EVENT KATEGORI
========================================= */

document
    .getElementById("filterKategori")
    .addEventListener(
        "change",
        terapkanFilter
    );


/* =========================================
   SORTING TAHUN
========================================= */

document
    .getElementById("thTahun")
    .addEventListener(
        "click",
        () => {

            arahSort =

                arahSort === "asc"

                    ? "desc"

                    :

                    (
                        arahSort === "desc"
                            ? null
                            : "asc"
                    );


            document.getElementById(
                "panahSort"
            ).textContent =

                arahSort === "asc"

                    ? "↑"

                    :

                    (
                        arahSort === "desc"
                            ? "↓"
                            : "↕"
                    );


            terapkanFilter();

        }
    );

</script>


</body>

</html>