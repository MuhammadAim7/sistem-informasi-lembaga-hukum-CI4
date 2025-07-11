<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= (isset($title) ? $title : 'FAGUSTIFA LAWFIRM') ?> - Layanan Hukum Profesional</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>"> </head>
     <script>
        // Definisikan URL API sebagai variabel JavaScript global
        const API_ENDPOINTS = {
            register: '<?= base_url('register') ?>',
            login: '<?= base_url('login') ?>', // Jika ada
            // Tambahkan endpoint lain jika diperlukan
        };
    </script>
<body>

    <header>
        <div class="container header-content">
            <a href="<?= base_url() ?>" class="logo">FAGUSTIFA LAWFIRM</a>
            <nav>
                <ul>
                    <li><a href="<?= base_url('#about') ?>">Tentang Kami</a></li>
                    <li><a href="<?= base_url('#services') ?>">Layanan</a></li>
                    <li><a href="<?= base_url('#team') ?>">Tim Kami</a></li>
                    <li><a href="<?= base_url('#contact') ?>">Kontak</a></li>
                    <li><a href="#" id="openLoginBtn" class="btn-secondary">Login / Register</a></li>
                </ul>
            </nav>
        </div>
    </header>