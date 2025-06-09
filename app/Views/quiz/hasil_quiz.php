<!-- Include Header -->
<?= view('header') ?>

<!-- External CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link rel="stylesheet" href="<?= base_url('css/soal.css') ?>">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="content-wrapper p-4">
    <!-- Judul Halaman -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">📋 Hasil Quiz</h2>
    </div>

    <!-- Form Pencarian -->
    <form method="get" action="<?= current_url() ?>" class="mb-4">
        <div class="row g-2 align-items-center">
            <div class="col-md-4">
                <input 
                    type="text" 
                    name="keyword" 
                    class="form-control" 
                    placeholder="🔍 Cari berdasarkan nama atau judul..." 
                    value="<?= esc($keyword ?? '') ?>">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Cari
                </button>
                <a href="<?= current_url() ?>" class="btn btn-secondary">
                    <i class="fas fa-sync-alt"></i> Reset
                </a>
            </div>
        </div>
    </form>

    <!-- Kartu Tabel Hasil Quiz -->
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0"><i class="fas fa-list-alt"></i> Daftar Hasil Quiz</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover table-sm m-0" style="min-width: 800px;">
                    <thead class="table-dark sticky-top">
                        <tr>
                            <th>Username</th>
                            <th>Judul</th>
                            <th>Score</th>
                            <th>Waktu Selesai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($hasil) && is_array($hasil)): ?>
                            <?php foreach ($hasil as $row): ?>
                                <tr>
                                    <td><?= esc($row['username']) ?></td>
                                    <td><?= esc($row['judul']) ?></td>
                                    <td><?= esc($row['score']) ?></td>
                                    <td><?= esc($row['waktu_selesai']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted">🔕 Belum ada hasil quiz tersedia.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Optional Custom JS -->
<script src="<?= base_url('js/soal.js') ?>"></script>

<?= view('footer') ?>
