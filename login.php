<?php
session_start();
require_once 'koneksi.php';

if (isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit;
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = "Username dan password wajib diisi.";
    } else {
        $stmt = $koneksi->prepare(
            "SELECT id, username, password FROM admins WHERE username = ?"
        );

        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $admin = $result->fetch_assoc();

            $cocok =
                ($password === $admin['password']) ||
                password_verify($password, $admin['password']);

            if ($cocok) {
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_username'] = $admin['username'];

                header("Location: dashboard.php");
                exit;
            } else {
                $error = "Username atau password salah.";
            }
        } else {
            $error = "Username atau password salah.";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Login | PerpusApi Digital Library</title>

    <link rel="stylesheet" href="style.css">

    <style>

        /* =====================================================
           RESET
        ===================================================== */

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html,
        body {
            width: 100%;
            min-height: 100%;
        }


        /* =====================================================
           COLOR THEME
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
                0 18px 45px
                rgba(91, 72, 52, .12);
        }


        /* =====================================================
           BODY
        ===================================================== */

        body.login-body {

            min-height: 100vh;

            font-family:
                "Segoe UI",
                Arial,
                sans-serif;

            color: var(--text);

            background:

                radial-gradient(
                    circle at 8% 10%,
                    rgba(169, 201, 207, .38),
                    transparent 23%
                ),

                radial-gradient(
                    circle at 92% 88%,
                    rgba(241, 213, 130, .28),
                    transparent 25%
                ),

                linear-gradient(
                    135deg,
                    #eef6f0 0%,
                    #fffaf1 48%,
                    #f8f1e7 100%
                );

            overflow-x: hidden;
        }


        /* =====================================================
           BACKGROUND SHAPES
        ===================================================== */

        .bg-shape {

            position: fixed;

            border-radius: 50%;

            pointer-events: none;

            z-index: 0;
        }

        .bg-shape.one {

            width: 190px;
            height: 190px;

            top: -80px;
            right: 8%;

            background:
                rgba(241, 213, 130, .42);
        }

        .bg-shape.two {

            width: 120px;
            height: 120px;

            bottom: -45px;
            left: 42%;

            background:
                rgba(169, 201, 207, .42);
        }

        .bg-shape.three {

            width: 90px;
            height: 90px;

            right: 4%;
            bottom: 10%;

            background:
                rgba(155, 185, 155, .30);
        }


        /* =====================================================
           FLOATING DECORATION
        ===================================================== */

        .floating-emoji {

            position: fixed;

            z-index: 5;

            pointer-events: none;

            user-select: none;

            font-size: 32px;

            animation:
                floatEmoji 4s ease-in-out infinite,
                swayEmoji 5s ease-in-out infinite;
        }

        .emoji-book-1 {
            left: 5%;
            top: 35%;
        }

        .emoji-book-2 {

            left: 37%;
            top: 45%;

            font-size: 38px;

            animation-delay: 1s;
        }

        .emoji-star {

            left: 20%;
            top: 17%;

            font-size: 27px;

            animation-delay: .6s;
        }

        .emoji-flower {

            left: 28%;
            bottom: 14%;

            font-size: 30px;

            animation-delay: 1.4s;
        }

        .emoji-sparkle {

            right: 7%;
            top: 25%;

            font-size: 29px;

            animation-delay: .8s;
        }

        .emoji-heart {

            right: 13%;
            bottom: 17%;

            font-size: 25px;

            animation-delay: 1.8s;
        }


        @keyframes floatEmoji {

            0%,
            100% {
                transform:
                    translateY(0)
                    rotate(-4deg);
            }

            50% {
                transform:
                    translateY(-20px)
                    rotate(7deg);
            }
        }


        @keyframes swayEmoji {

            0%,
            100% {
                margin-left: 0;
            }

            50% {
                margin-left: 10px;
            }
        }


        /* =====================================================
           MAIN
        ===================================================== */

        .login-page {

            position: relative;

            z-index: 3;

            min-height: 100vh;

            display: flex;

            align-items: center;

            justify-content: center;

            padding: 22px 35px;
        }


        .login-wrapper {

            width: 100%;

            max-width: 1250px;

            min-height: 680px;

            max-height: 820px;

            display: grid;

            grid-template-columns:
                1fr 1fr;

            border-radius: 30px;

            overflow: hidden;

            position: relative;

            background:
                rgba(255,255,255,.45);

            box-shadow:
                0 25px 70px
                rgba(91,72,52,.10);

            border:
                1px solid
                rgba(229,217,198,.75);
        }


        /* =====================================================
           LEFT SIDE
        ===================================================== */

        .login-left {

            position: relative;

            display: flex;

            flex-direction: column;

            align-items: center;

            justify-content: center;

            padding: 35px;

            background:

                radial-gradient(
                    circle at 20% 20%,
                    rgba(169,201,207,.28),
                    transparent 25%
                ),

                linear-gradient(
                    145deg,
                    #e7f2eb,
                    #fffaf0
                );
        }


        /* =====================================================
           BRAND
        ===================================================== */

        .brand {

            position: absolute;

            top: 35px;
            left: 40px;

            display: flex;

            align-items: center;

            gap: 12px;
        }


        .brand-icon {

            width: 55px;
            height: 55px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 17px;

            background:
                var(--green-light);

            font-size: 27px;

            box-shadow:
                0 8px 20px
                rgba(91,72,52,.10);
        }


        .brand-text h2 {

            font-family:
                Georgia,
                "Times New Roman",
                serif;

            font-size: 25px;

            color:
                var(--brown-dark);

            letter-spacing: -.5px;
        }


        .brand-text h2 span {

            color:
                var(--green-dark);
        }


        .brand-text p {

            margin-top: 3px;

            color:
                #78958b;

            font-size: 12px;
        }


        /* =====================================================
           MASCOT AREA
        ===================================================== */

        .mascot-area {

            position: relative;

            width: 350px;
            height: 285px;

            display: flex;

            align-items: flex-start;

            justify-content: center;

            margin-top: 55px;
        }


        .mascot-shadow {

            position: absolute;

            width: 155px;
            height: 24px;

            bottom: 12px;

            background:
                rgba(82,95,91,.13);

            border-radius: 50%;

            filter: blur(5px);
        }


        /* =====================================================
           MASCOT
        ===================================================== */

        .mascot {

            position: relative;

            width: 150px;
            height: 155px;

            margin-top: 15px;

            background:
                #d9d2ca;

            border-radius:
                48% 48% 43% 43%;

            box-shadow:

                inset -10px -8px 0
                rgba(150,138,126,.08),

                0 15px 25px
                rgba(80,85,80,.10);

            animation:
                mascotFloat 3.5s
                ease-in-out
                infinite;
        }


        @keyframes mascotFloat {

            0%,
            100% {
                transform:
                    translateY(0);
            }

            50% {
                transform:
                    translateY(-8px);
            }
        }


        /* =====================================================
           EARS
        ===================================================== */

        .ear {

            position: absolute;

            width: 60px;
            height: 60px;

            top: -15px;

            background:
                #d9d2ca;

            border-radius: 50%;
        }

        .ear.left {
            left: -7px;
        }

        .ear.right {
            right: -7px;
        }


        /* =====================================================
           EYES - DIPERBAIKI
        ===================================================== */

        .eye {

            position: absolute;

            width: 44px;
            height: 34px;

            top: 47px;

            background:
                #fffdf8;

            border:
                5px solid
                #596466;

            border-radius: 50%;

            z-index: 5;

            overflow: hidden;
        }


        .eye.left {
            left: 20px;
        }

        .eye.right {
            right: 20px;
        }


        /* PUPIL */

        .eye::after {

            content: "";

            position: absolute;

            width: 14px;
            height: 18px;

            left: 50%;
            top: 50%;

            transform:
                translate(-50%, -48%);

            background:
                #303638;

            border-radius: 50%;
        }


        /* KILAU MATA */

        .eye::before {

            content: "";

            position: absolute;

            width: 5px;
            height: 5px;

            left: 58%;
            top: 27%;

            background:
                white;

            border-radius: 50%;

            z-index: 2;
        }


        /* =====================================================
           CHEEK
        ===================================================== */

        .cheek {

            position: absolute;

            width: 18px;
            height: 9px;

            background:
                #d9a38f;

            opacity: .75;

            border-radius: 50%;

            top: 91px;

            z-index: 3;
        }

        .cheek.left {
            left: 17px;
        }

        .cheek.right {
            right: 17px;
        }


        /* =====================================================
           NOSE
        ===================================================== */

        .nose {

            position: absolute;

            width: 6px;
            height: 6px;

            background:
                #594b43;

            border-radius: 50%;

            top: 91px;
            left: 50%;

            transform:
                translateX(-50%);

            z-index: 4;
        }


        /* =====================================================
           MOUTH
        ===================================================== */

        .mouth {

            position: absolute;

            width: 17px;
            height: 9px;

            border-bottom:
                2px solid
                #594b43;

            border-radius:
                0 0 50% 50%;

            left: 50%;
            top: 98px;

            transform:
                translateX(-50%);

            z-index: 4;
        }


        /* =====================================================
           MASCOT CARD
           SEKARANG DI BAWAH WAJAH
        ===================================================== */

        .mascot-card {

            position: absolute;

            width: 155px;
            height: 70px;

            left: 50%;

            top: 125px;

            transform:
                translateX(-50%)
                rotate(-2deg);

            background:
                var(--green-dark);

            border-radius: 14px;

            display: flex;

            flex-direction: column;

            align-items: center;

            justify-content: center;

            color:
                white;

            box-shadow:
                0 11px 22px
                rgba(91,72,52,.18);

            z-index: 2;
        }


        .mascot-card strong {

            font-size: 18px;

            letter-spacing: .5px;
        }


        .mascot-card span {

            margin-top: 5px;

            font-size: 11px;
        }


        /* =====================================================
           WELCOME TEXT
        ===================================================== */

        .welcome-text {

            text-align: center;

            margin-top: 0;

            max-width: 480px;
        }


        .welcome-text h1 {

            font-family:
                Georgia,
                "Times New Roman",
                serif;

            font-size: 55px;

            line-height: .98;

            font-weight: 400;

            color:
                var(--brown-dark);

            letter-spacing: -2px;
        }


        .welcome-text h1 span {

            display: block;

            color:
                var(--green-dark);
        }


        .welcome-text p {

            margin: 17px auto 0;

            max-width: 450px;

            font-size: 15px;

            line-height: 1.6;

            color:
                #71847a;
        }


        /* =====================================================
           RIGHT SIDE
        ===================================================== */

        .login-right {

            position: relative;

            display: flex;

            align-items: center;

            justify-content: center;

            padding: 35px;

            background:

                radial-gradient(
                    circle at 90% 5%,
                    rgba(241,213,130,.38),
                    transparent 17%
                ),

                linear-gradient(
                    135deg,
                    #fffdf8,
                    #f9f4eb
                );
        }


        /* =====================================================
           LOGIN CARD
        ===================================================== */

        .login-card {

            width: 100%;

            max-width: 500px;

            padding:
                45px
                45px
                38px;

            background:
                rgba(255,255,255,.97);

            border-radius: 27px;

            box-shadow:
                var(--shadow);

            border:
                1px solid
                var(--border);
        }


        /* =====================================================
           HEADER
        ===================================================== */

        .login-header {

            margin-bottom: 28px;
        }


        .login-header h1 {

            font-family:
                Georgia,
                "Times New Roman",
                serif;

            font-size: 32px;

            font-weight: 400;

            color:
                var(--brown-dark);
        }


        .wave {

            display: inline-block;

            animation:
                waveHand 1.8s
                ease-in-out
                infinite;

            transform-origin:
                70% 70%;
        }


        @keyframes waveHand {

            0%,
            60%,
            100% {
                transform: rotate(0deg);
            }

            10%,
            30% {
                transform: rotate(14deg);
            }

            20%,
            40% {
                transform: rotate(-9deg);
            }
        }


        .login-header p {

            margin-top: 10px;

            color:
                var(--text-soft);

            font-size: 14px;
        }


        /* =====================================================
           ERROR
        ===================================================== */

        .error-message {

            margin-bottom: 18px;

            padding: 13px 15px;

            border-radius: 12px;

            background:
                #fff0e9;

            color:
                #a96350;

            border:
                1px solid
                #efd1c4;

            font-size: 13px;
        }


        /* =====================================================
           FORM
        ===================================================== */

        .form-group {

            margin-bottom: 19px;
        }


        .form-group label {

            display: block;

            margin-bottom: 8px;

            color:
                var(--brown-dark);

            font-weight: 600;

            font-size: 13px;
        }


        .input-wrapper {

            position: relative;
        }


        .input-icon {

            position: absolute;

            left: 18px;
            top: 50%;

            transform:
                translateY(-50%);

            font-size: 18px;

            z-index: 2;
        }


        .form-input {

            width: 100%;

            height: 55px;

            padding:
                0 18px
                0 52px;

            border-radius: 15px;

            border:
                1px solid
                #dedfd4;

            outline: none;

            background:
                #f8faf6;

            color:
                var(--text);

            font-size: 14px;

            transition:
                .25s ease;

            font-family:
                inherit;
        }


        .form-input::placeholder {

            color:
                #9a9b91;
        }


        .form-input:hover {

            border-color:
                #b7cbb6;
        }


        .form-input:focus {

            background:
                white;

            border-color:
                var(--green);

            box-shadow:

                0 0 0 4px
                rgba(155,185,155,.15);
        }


        /* =====================================================
           REMEMBER
        ===================================================== */

        .remember-row {

            display: flex;

            align-items: center;

            margin:
                3px 0
                22px;

            color:
                var(--text-soft);

            font-size: 13px;
        }


        .remember-row input {

            width: 18px;
            height: 18px;

            margin-right: 9px;

            accent-color:
                var(--green-dark);
        }


        /* =====================================================
           LOGIN BUTTON
        ===================================================== */

        .login-button {

            width: 100%;

            height: 53px;

            border: none;

            border-radius: 15px;

            cursor: pointer;

            color: white;

            font-size: 14px;

            font-weight: 700;

            letter-spacing: .7px;

            background:

                linear-gradient(
                    135deg,
                    #8fac8f,
                    #6f916f
                );

            box-shadow:

                0 10px 22px
                rgba(111,145,111,.24);

            transition:
                transform .2s ease,
                box-shadow .2s ease;
        }


        .login-button:hover {

            transform:
                translateY(-2px);

            box-shadow:

                0 14px 26px
                rgba(111,145,111,.30);
        }


        .login-button:active {

            transform:
                translateY(0);
        }


        /* =====================================================
           LINKS
        ===================================================== */

        .forgot-password {

            display: block;

            text-align: center;

            margin-top: 21px;

            color:
                #789b9f;

            text-decoration: none;

            font-size: 13px;

            transition: .2s;
        }


        .forgot-password:hover {

            color:
                var(--green-dark);
        }


        .divider {

            display: flex;

            align-items: center;

            gap: 13px;

            margin: 28px 0;
        }


        .divider::before,
        .divider::after {

            content: "";

            flex: 1;

            height: 1px;

            background:
                #e3dfd5;
        }


        .divider span {

            color:
                #a09b91;

            font-size: 12px;
        }


        .register-text {

            text-align: center;

            color:
                var(--text-soft);

            font-size: 13px;
        }


        .register-text a {

            color:
                var(--green-dark);

            text-decoration: none;

            font-weight: 700;
        }


        .register-text a:hover {

            text-decoration: underline;
        }


        .back-home {

            display: block;

            text-align: center;

            margin-top: 26px;

            color:
                #8a8980;

            text-decoration: none;

            font-size: 13px;
        }


        .back-home:hover {

            color:
                var(--green-dark);
        }


        /* =====================================================
           ACCOUNT HINT
        ===================================================== */

        .account-hint {

            margin-top: 19px;

            padding: 11px 14px;

            text-align: center;

            border-radius: 11px;

            background:
                var(--yellow-light);

            color:
                #8b7540;

            font-size: 11px;

            border:
                1px solid
                #eedda4;
        }


        /* =====================================================
           RESPONSIVE TABLET
        ===================================================== */

        @media (max-width: 1100px) {

            .login-page {
                padding: 20px;
            }

            .login-wrapper {

                grid-template-columns: 1fr;

                max-width: 650px;

                max-height: none;
            }

            .login-left {

                min-height: 600px;
            }

            .login-right {

                min-height: auto;
            }

            .brand {

                position: relative;

                top: auto;
                left: auto;

                align-self: flex-start;

                margin-bottom: 5px;
            }

            .mascot-area {

                margin-top: 20px;
            }

            .welcome-text {

                margin-top: 0;
            }
        }


        /* =====================================================
           RESPONSIVE HP
        ===================================================== */

        @media (max-width: 650px) {

            .login-page {

                padding: 10px;
            }

            .login-wrapper {

                border-radius: 22px;
            }

            .login-left {

                padding: 30px 18px;

                min-height: 535px;
            }

            .login-right {

                padding: 15px 10px;
            }

            .brand {

                align-self: center;
            }

            .brand-icon {

                width: 50px;
                height: 50px;

                font-size: 25px;
            }

            .brand-text h2 {

                font-size: 23px;
            }

            .mascot-area {

                transform: scale(.78);

                margin-top: 0;

                margin-bottom: -5px;
            }

            .welcome-text h1 {

                font-size: 50px;
            }

            .welcome-text p {

                font-size: 13px;
            }

            .login-card {

                padding:
                    35px
                    22px
                    30px;

                border-radius: 23px;
            }

            .login-header h1 {

                font-size: 29px;
            }

            .floating-emoji {

                font-size: 25px;
            }

            .emoji-book-2 {

                display: none;
            }
        }


        /* =====================================================
           SMALL HP
        ===================================================== */

        @media (max-width: 400px) {

            .login-left {

                min-height: 500px;
            }

            .mascot-area {

                transform: scale(.68);

                margin-top: -5px;

                margin-bottom: -20px;
            }

            .welcome-text h1 {

                font-size: 43px;
            }

            .login-card {

                padding:
                    30px
                    18px
                    25px;
            }

            .login-header h1 {

                font-size: 26px;
            }
        }


        /* =====================================================
           REDUCE MOTION
        ===================================================== */

        @media (prefers-reduced-motion: reduce) {

            .floating-emoji,
            .mascot,
            .wave {

                animation: none;
            }
        }

    </style>

</head>


<body class="login-body">


    <!-- =====================================================
         BACKGROUND
    ===================================================== -->

    <div class="bg-shape one"></div>
    <div class="bg-shape two"></div>
    <div class="bg-shape three"></div>


    <!-- =====================================================
         FLOATING DECORATION
    ===================================================== -->

    <div class="floating-emoji emoji-book-1">
        📚
    </div>

    <div class="floating-emoji emoji-book-2">
        📖
    </div>

    <div class="floating-emoji emoji-star">
        ✦
    </div>

    <div class="floating-emoji emoji-flower">
        🌿
    </div>

    <div class="floating-emoji emoji-sparkle">
        ✨
    </div>

    <div class="floating-emoji emoji-heart">
        🍃
    </div>


    <!-- =====================================================
         MAIN
    ===================================================== -->

    <main class="login-page">

        <div class="login-wrapper">


            <!-- =================================================
                 LEFT SIDE
            ================================================= -->

            <section class="login-left">


                <!-- BRAND -->

                <div class="brand">

                    <div class="brand-icon">
                        📖
                    </div>

                    <div class="brand-text">

                        <h2>
                            Perpus<span>Api</span>
                        </h2>

                        <p>
                            Digital Library
                        </p>

                    </div>

                </div>


                <!-- =================================================
                     MASCOT
                ================================================= -->

                <div class="mascot-area">

                    <div class="mascot-shadow"></div>


                    <div class="mascot">

                        <div class="ear left"></div>

                        <div class="ear right"></div>


                        <!-- MATA -->

                        <div class="eye left"></div>

                        <div class="eye right"></div>


                        <!-- PIPI -->

                        <div class="cheek left"></div>

                        <div class="cheek right"></div>


                        <!-- HIDUNG -->

                        <div class="nose"></div>


                        <!-- MULUT -->

                        <div class="mouth"></div>


                        <!-- CARD SEKARANG DI BAWAH MATA -->

                        <div class="mascot-card">

                            <strong>
                                HELLO!
                            </strong>

                            <span>
                                Let's Read 📚
                            </span>

                        </div>

                    </div>

                </div>


                <!-- =================================================
                     WELCOME
                ================================================= -->

                <div class="welcome-text">

                    <h1>

                        Welcome

                        <span>
                            Back!
                        </span>

                    </h1>

                    <p>
                        Yuk lanjutkan perjalanan membaca dan
                        temukan cerita baru hari ini. 📚✨
                    </p>

                </div>

            </section>


            <!-- =================================================
                 RIGHT SIDE
            ================================================= -->

            <section class="login-right">

                <div class="login-card">


                    <!-- HEADER -->

                    <div class="login-header">

                        <h1>

                            Selamat Datang!

                            <span class="wave">
                                👋
                            </span>

                        </h1>

                        <p>
                            Login untuk masuk ke
                            perpustakaan digital
                        </p>

                    </div>


                    <!-- ERROR -->

                    <?php if ($error): ?>

                        <div class="error-message">

                            ⚠️

                            <?= htmlspecialchars($error) ?>

                        </div>

                    <?php endif; ?>


                    <!-- FORM -->

                    <form method="POST">


                        <!-- USERNAME -->

                        <div class="form-group">

                            <label for="username">
                                Username
                            </label>

                            <div class="input-wrapper">

                                <span class="input-icon">
                                    👤
                                </span>

                                <input
                                    type="text"
                                    id="username"
                                    name="username"
                                    class="form-input"
                                    placeholder="Masukkan username"
                                    autocomplete="username"
                                    required
                                >

                            </div>

                        </div>


                        <!-- PASSWORD -->

                        <div class="form-group">

                            <label for="password">
                                Password
                            </label>

                            <div class="input-wrapper">

                                <span class="input-icon">
                                    🔐
                                </span>

                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    class="form-input"
                                    placeholder="Masukkan password"
                                    autocomplete="current-password"
                                    required
                                >

                            </div>

                        </div>


                        <!-- REMEMBER -->

                        <div class="remember-row">

                            <input
                                type="checkbox"
                                id="remember"
                                name="remember"
                            >

                            <label for="remember">
                                Ingat saya
                            </label>

                        </div>


                        <!-- LOGIN -->

                        <button
                            type="submit"
                            class="login-button"
                        >
                            LOGIN SEKARANG →
                        </button>

                    </form>


                    <!-- FORGOT -->

                    <a
                        href="#"
                        class="forgot-password"
                        onclick="return false;"
                    >
                        Lupa password?
                    </a>


                    <!-- DIVIDER -->

                    <div class="divider">

                        <span>
                            atau
                        </span>

                    </div>


                    <!-- REGISTER -->

                    <div class="register-text">

                        Belum punya akun?

                        <a href="register.php">
                            Daftar sekarang
                        </a>

                    </div>


                    <!-- HOME -->

                    <a
                        href="index.php"
                        class="back-home"
                    >
                        ← Kembali ke halaman utama
                    </a>


                    <!-- ACCOUNT HINT -->

                    <div class="account-hint">

                        💡 Akun contoh:
                        <strong>admin</strong>
                        /
                        <strong>admin123</strong>

                    </div>

                </div>

            </section>

        </div>

    </main>

</body>

</html>