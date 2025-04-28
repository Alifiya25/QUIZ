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
                                <?php foreach ($peserta as $index => $p): ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td><?= esc($p['username']) ?></td>
                                        <td><?= esc($p['email']) ?></td>
                                        <td class="text-center">
                                            <span class="badge bg-success"><?= esc($p['role']) ?></span>
                                        </td>
                                        <td class="text-center">
                                            <a href="<?= base_url('admin/form_edit_peserta/' . $p['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                                            <button type="button"
                                                class="btn btn-sm btn-danger btn-hapus-peserta"
                                                data-id="<?= $p['id'] ?>"
                                                data-nama="<?= esc($p['username']) ?>">
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

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SweetAlert Logic -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle tombol hapus
            const hapusButtons = document.querySelectorAll('.btn-hapus-peserta');

            hapusButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const nama = this.dataset.nama;

                    Swal.fire({
                        title: `Hapus ${nama} dari Dunia?`,
                        text: "Data peserta akan dihapus secara permanen!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = `/admin/delete_peserta/${id}`;
                        }
                    });
                });
            });

            // Flashdata notifikasi (jika ada)
            <?php if (session()->getFlashdata('message')): ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '<?= session()->getFlashdata("message") ?>',
                    confirmButtonColor: '#3085d6'
                });
            <?php elseif (session()->getFlashdata('error')): ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '<?= session()->getFlashdata("error") ?>',
                    confirmButtonColor: '#d33'
                });
            <?php endif; ?>
        });
    </script>
</body>

</html>