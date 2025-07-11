<?= $this->extend('layout/template') ?>

<?= $this->section('title') ?>
Dashboard Klien
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Selamat Datang, <?= session()->get('nama_lengkap') ?>!</h3>
    <a href="<?= site_url('klien/ajukan-pertanyaan') ?>" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Ajukan Pertanyaan Baru</a>
</div>

<div class="card">
    <div class="card-header">
        Riwayat Konsultasi Anda
    </div>
    <div class="card-body">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Subjek Pertanyaan</th>
                        <th>Tanggal Diajukan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($konsultasi)): ?>
                        <?php $no = 1; foreach ($konsultasi as $item): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= esc($item['subjek_pertanyaan']) ?></td>
                                <td><?= date('d M Y, H:i', strtotime($item['tanggal_diajukan'])) ?></td>
                                <td>
                                    <?php if ($item['status'] == 'dijawab'): ?>
                                        <span class="badge bg-success">Sudah Dijawab</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">Menunggu Jawaban</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal<?= $item['id_konsultasi'] ?>">
                                        <i class="bi bi-eye"></i> Detail
                                    </button>
                                </td>
                            </tr>

                            <div class="modal fade" id="detailModal<?= $item['id_konsultasi'] ?>" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Detail Konsultasi</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <h5>Pertanyaan Anda:</h5>
                                            <p><strong>Subjek:</strong> <?= esc($item['subjek_pertanyaan']) ?></p>
                                            <p><?= nl2br(esc($item['detail_pertanyaan'])) ?></p>
                                            <hr>
                                            <h5>Jawaban dari Advokat:</h5>
                                            <?php if ($item['status'] == 'dijawab'): ?>
                                                <p><?= nl2br(esc($item['jawaban_konsultasi'])) ?></p>
                                                <small class="text-muted">Dijawab pada: <?= date('d M Y, H:i', strtotime($item['tanggal_dijawab'])) ?></small>
                                            <?php else: ?>
                                                <p class="text-muted">Belum ada jawaban.</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">Anda belum pernah mengajukan pertanyaan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>