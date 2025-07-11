<?= $this->extend('templates/auth_template') ?>

<?= $this->section('title') ?>
    Registrasi
<?= $this->endSection() ?>

<?= $this->section('subtitle') ?>
    Buat akun baru untuk memulai.
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<form action="<?= base_url('/register') ?>" method="post" class="auth-form">
    <?= csrf_field() ?>
    <div class="input-group">
        <label for="nama_lengkap">Nama Lengkap</label>
        <input type="text" id="nama_lengkap" name="nama_lengkap" placeholder="Masukkan nama lengkap Anda" required>
    </div>
    <div class="input-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="contoh@email.com" required>
    </div>
    <div class="input-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Minimal 8 karakter" required>
    </div>
    <button type="submit" class="btn">Daftar</button>
    <div class="bottom-text">
        <p>Sudah punya akun? <a href="<?= base_url('/login') ?>">Login di sini</a></p>
    </div>
</form>
<?= $this->endSection() ?>