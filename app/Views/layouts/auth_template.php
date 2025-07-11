<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?> | Sistem Layanan Hukum</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body>
    <div class="main-container">
        <div class="form-container">
            <div class="form-header">
                <img src="https://i.ibb.co/L1g1g3j/law-icon.png" alt="Logo" class="logo">
                <h1><?= $this->renderSection('title') ?></h1>
                <p><?= $this->renderSection('subtitle') ?></p>
            </div>
            
            <?= $this->renderSection('content') ?>

        </div>
        <div class="image-container">
            <div class="overlay"></div>
            <div class="image-text">
                <h2>Solusi Hukum Profesional</h2>
                <p>Dapatkan bantuan hukum dari para ahli terpercaya dengan cepat dan mudah.</p>
            </div>
        </div>
    </div>

    <script src="<?= base_url('js/script.js') ?>"></script>
</body>
</html>