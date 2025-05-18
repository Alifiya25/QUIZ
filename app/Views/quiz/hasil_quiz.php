<!-- Include Header -->
<?= view('header') ?>

<!-- External CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link rel="stylesheet" href="<?= base_url('css/soal.css') ?>">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="content-wrapper p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Hasil Quiz</h2>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Daftar Hasil Quiz</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div style="max-height: 400px; overflow-y: auto;">
                    <table class="table table-striped table-bordered table-hover table-sm" style="min-width: 900px;">
                        <thead class="table-dark" style="position: sticky; top: 0; z-index: 2;">
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>ID Quiz</th>
                                <th>Score</th>
                                <th>Waktu Selesai</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($hasil) && is_array($hasil)): ?>
                                <?php foreach ($hasil as $row): ?>
                                    <tr>
                                        <td><?= esc($row['id']) ?></td>
                                        <td><?= esc($row['username']) ?></td>
                                        <td><?= esc($row['id_quiz']) ?></td>
                                        <td><?= esc($row['score']) ?></td>
                                        <td><?= esc($row['waktu_selesai']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada hasil quiz tersedia.</td>
                                </tr>
                            <?php endif; ?>
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
