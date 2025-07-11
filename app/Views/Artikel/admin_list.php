<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Kelola Artikel Hukum</h3>
    <a href="<?= site_url('artikel/create') ?>" class="btn btn-success"><i class="bi bi-plus-circle"></i> Tambah Artikel</a>
</div>

<div class="card">
    <div class="card-body">
        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <table class="table">
            <thead>
                <tr><th>Judul</th><th>Tanggal Publikasi</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                <?php foreach($artikel as $item): ?>
                <tr>
                    <td><?= esc($item['judul']) ?></td>
                    <td><?= date('d M Y', strtotime($item['tanggal_publikasi'])) ?></td>
                    <td>
                        <a href="<?= site_url('artikel/edit/'.$item['id_artikel']) ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="<?= site_url('artikel/delete/'.$item['id_artikel']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus artikel ini?')">Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>