<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard Peserta</title>
    <link rel="stylesheet" href="<?= base_url('css/dashboard.css') ?>" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <?php include(__DIR__ . '/../header.php'); ?>

    <div class="content">
        <div class="header">
            <img src="<?= base_url('img/LogoQ&A.png') ?>" alt="Logo" class="logo" />
            <h1>Welcome to Peserta, <?= session()->get('username') ?>!</h1>
        </div>

        <?php if ($error = session()->getFlashdata('error')) : ?>
            <script>
                window.onload = function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: '<?= esc($error) ?>',
                        confirmButtonText: 'Tutup'
                    });
                }
            </script>
        <?php endif; ?>

        <!-- Form untuk kode akses quiz -->
        <div class="quiz-access-form">
            <form action="<?= base_url('join-quiz') ?>" method="post">
                <input type="text" name="kode_akses" placeholder="Kode Akses" required />
                <button type="submit" class="btn-join">Join</button>
            </form>
        </div>
    </div>

    <?= view('footer') ?>
</body>
</html>
