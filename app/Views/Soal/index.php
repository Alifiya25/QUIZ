<!-- Include Header -->
<?= $this->include('header') ?>

<!-- External JS & CSS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link rel="stylesheet" href="<?= base_url('css/soal.css') ?>">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Content Wrapper -->
<div class="content-wrapper p-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Daftar Soal</h2>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambahSoal">
            <i class="fas fa-plus"></i> Tambah Soal
        </button>
    </div>

    <!-- SweetAlert Notifications -->
    <script>
        <?php if (session()->getFlashdata('success')): ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '<?= session()->getFlashdata('success') ?>',
                confirmButtonColor: '#3085d6'
            });
        <?php elseif (session()->getFlashdata('error')): ?>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '<?= session()->getFlashdata('error') ?>',
                confirmButtonColor: '#d33'
            });
        <?php endif; ?>
    </script>

    <!-- Soal Table -->
    <div class="card">
        <div class="card-header">
            <h5>Daftar Soal</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div style="max-height: 400px; overflow-y: auto;">
                    <table class="table table-striped table-bordered table-hover table-sm" style="min-width: 1000px;">
                        <thead class="table-dark" style="position: sticky; top: 0; z-index: 2;">
                            <tr>
                                <th>No</th>
                                <th>Pertanyaan</th>
                                <th>Opsi A</th>
                                <th>Opsi B</th>
                                <th>Opsi C</th>
                                <th>Opsi D</th>
                                <th>Jawaban</th>
                                <th style="width: 150px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($soal) && is_array($soal)): ?>
                                <?php foreach ($soal as $key => $row): ?>
                                    <tr>
                                        <td><?= $key + 1 ?></td>
                                        <td><?= esc($row['soal']) ?></td>
                                        <td><?= esc($row['pilihan_a']) ?></td>
                                        <td><?= esc($row['pilihan_b']) ?></td>
                                        <td><?= esc($row['pilihan_c']) ?></td>
                                        <td><?= esc($row['pilihan_d']) ?></td>
                                        <td><?= esc($row['jawaban_benar']) ?></td>
                                        <td>
                                            <div class="d-flex">
                                                <!-- Edit Button -->
                                                <button type="button" class="btn btn-sm btn-warning btn-edit-soal me-2"
                                                    data-bs-toggle="modal" data-bs-target="#modalEditSoal"
                                                    data-id="<?= $row['id'] ?>"
                                                    data-soal="<?= htmlspecialchars($row['soal'], ENT_QUOTES) ?>"
                                                    data-a="<?= htmlspecialchars($row['pilihan_a'], ENT_QUOTES) ?>"
                                                    data-b="<?= htmlspecialchars($row['pilihan_b'], ENT_QUOTES) ?>"
                                                    data-c="<?= htmlspecialchars($row['pilihan_c'], ENT_QUOTES) ?>"
                                                    data-d="<?= htmlspecialchars($row['pilihan_d'], ENT_QUOTES) ?>"
                                                    data-jawaban="<?= $row['jawaban_benar'] ?>">
                                                    <i class="fas fa-edit"></i> Edit
                                                </button>

                                                <!-- Delete Button -->
                                                <button 
                                                    type="button" 
                                                    class="btn btn-sm btn-danger btn-delete-soal" 
                                                    data-id="<?= $row['id'] ?>">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center">Belum ada soal.</td>
                                </tr>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals for Add, Edit, and Delete Soal -->
    <?= $this->include('Soal/Modal/tambah') ?>
    <?= $this->include('Soal/Modal/edit') ?>
    <?= $this->include('Soal/Modal/hapus') ?>
    <?= $this->include('Soal/Modal/buat_quiz') ?>
    <?= $this->include('Soal/Modal/kode_akses') ?>

</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- External JS File -->
<script src="<?= base_url('js/soal.js') ?>"></script>
