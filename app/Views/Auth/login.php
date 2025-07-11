<?= $this->extend('templates/auth_template') ?>

<?= $this->section('title') ?>
    Login
<?= $this->endSection() ?>

<?= $this->section('subtitle') ?>
    Selamat datang kembali! Silakan masuk ke akun Anda.
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('msg')): ?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('msg') ?>
    </div>
<?php endif; ?>

<form action="<?= base_url('/login') ?>" method="post" class="auth-form">
    <?= csrf_field() ?>
    <div class="input-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Masukkan email Anda" required>
    </div>
    <div class="input-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Masukkan password Anda" required>
    </div>
    <button type="submit" class="btn">Login</button>
    <div class="bottom-text">
        <p>Belum punya akun? <a href="<?= base_url('/register') ?>">Daftar sekarang</a></p>
    </div>
</form>
<?= $this->endSection() ?>