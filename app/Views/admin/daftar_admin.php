<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="<?= base_url('css/daftarUser.css') ?>">
</head>

<body>
    <?= view('header') ?>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card-custom">
                    <h2 class="mb-4"><?= esc($title) ?></h2>

                    <!-- Form Search + Sort -->
                    <div class="mb-3 d-flex justify-content-between align-items-center flex-wrap">
                        <form method="get" class="d-flex flex-wrap gap-2">
                            <input type="text" name="search" class="form-control form-control-sm"
                                placeholder="Cari nama atau email..." value="<?= esc($_GET['search'] ?? '') ?>">

                            <select name="sort" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="asc" <?= ($_GET['sort'] ?? '') === 'asc' ? 'selected' : '' ?>>Nama A-Z</option>
                                <option value="desc" <?= ($_GET['sort'] ?? '') === 'desc' ? 'selected' : '' ?>>Nama Z-A</option>
                            </select>

                            <button type="submit" class="btn btn-sm btn-primary">Cari</button>

                            <?php if (!empty($_GET['search']) || !empty($_GET['sort'])): ?>
                                <a href="<?= base_url('admin/daftar_admin') ?>" class="btn btn-sm btn-secondary">Reset</a>
                            <?php endif; ?>
                        </form>
                    </div>

                    <!-- Tombol Tambah -->
                    <div class="text-end mb-3">
                        <a href="/admin/form_tambah_admin" class="btn btn-success">+ Tambah Data</a>
                    </div>

                    <!-- Tabel Admin -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-dark text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($admin as $index => $a): ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td><?= esc($a['username']) ?></td>
                                        <td><?= esc($a['email']) ?></td>
                                        <td class="text-center">
                                            <span class="badge bg-success"><?= esc($a['role']) ?></span>
                                        </td>
                                        <td class="text-center">
                                            <a href="<?= base_url('admin/form_edit_admin/' . $a['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                                            <button
                                                type="button"
                                                class="btn btn-sm btn-danger btn-hapus-admin"
                                                data-id="<?= $a['id'] ?>"
                                                data-nama="<?= esc($a['username']) ?>">
                                                Hapus
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                        <a href="/dashboard/admin" class="btn btn-secondary mt-3">← Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?= view('footer') ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SweetAlert Konfirmasi + Flash Message -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hapusButtons = document.querySelectorAll('.btn-hapus-admin');

            hapusButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const nama = this.dataset.nama;

                    Swal.fire({
                        title: `Hapus ${nama}?`,
                        text: "Data admin akan dihapus secara permanen!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = `/admin/delete_admin/${id}`;
                        }
                    });
                });
            });

            <?php if (session()->getFlashdata('message')): ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: <?= json_encode(session()->getFlashdata('message')) ?>,
                    confirmButtonColor: '#3085d6'
                });
            <?php elseif (session()->getFlashdata('error')): ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: <?= json_encode(session()->getFlashdata('error')) ?>,
                    confirmButtonColor: '#d33'
                });
            <?php endif; ?>
        });
    </script>

</body>

</html>