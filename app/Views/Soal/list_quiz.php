<!-- Include Header -->
<?= view('header') ?>

<!-- External CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link rel="stylesheet" href="<?= base_url('css/soal.css') ?>">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Content Wrapper -->
<div class="content-wrapper p-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Daftar Quiz</h2>
    </div>

    <!-- Quiz Table -->
    <div class="card">
        <div class="card-header">
            <h5>Daftar Quiz</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div style="max-height: 400px; overflow-y: auto;">
                    <table class="table table-striped table-bordered table-hover table-sm" style="min-width: 1000px;">
                        <thead class="table-dark" style="position: sticky; top: 0; z-index: 2;">
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Deskripsi</th>
                                <th>Mode</th>
                                <th>Timer (Menit)</th>
                                <th>Kode Akses</th>
                                <th>Tanggal Dibuat</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($quiz) && is_array($quiz)): ?>
                                <?php foreach ($quiz as $key => $quizItem): ?>
                                    <tr>
                                        <td><?= $key + 1 ?></td>
                                        <td><?= esc($quizItem['judul']) ?></td>
                                        <td><?= esc($quizItem['deskripsi']) ?></td>
                                        <td><?= esc($quizItem['mode']) ?></td>
                                        <td><?= esc($quizItem['timer'] / 60) ?> menit</td>
                                        <td><?= esc($quizItem['kode_akses']) ?></td>
                                        <td><?= esc($quizItem['tanggal_dibuat']) ?></td>
                                    </tr>
                                <?php endforeach ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center">Belum ada quiz tersedia.</td>
                                </tr>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Optional Custom JS -->
<script src="<?= base_url('js/soal.js') ?>"></script>

<?= view('footer') ?>
