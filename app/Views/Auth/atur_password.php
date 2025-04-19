<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Atur Password | Quizzy</title>
    <link rel="stylesheet" href="<?= base_url('css/auth.css') ?>">
</head>
<body>
<div class="auth-container">
    <div class="auth-card">
        <h2>Atur Password</h2>
        <p>Silakan atur password baru untuk akun Anda.</p>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <form method="post" action="<?= base_url('atur-password') ?>">
            <div class="input-group">
                <label for="password">Password Baru</label>
                <input type="password" name="password" required placeholder="Masukkan password baru">
            </div>

            <div class="input-group">
                <label for="konfirmasi">Konfirmasi Password</label>
                <input type="password" name="konfirmasi" required placeholder="Ulangi password baru">
            </div>

            <button class="btn" type="submit">Simpan Password</button>
        </form>

        <div class="links">
            <a href="<?= base_url('login') ?>">Kembali ke Login</a>
        </div>
    </div>
</div>
</body>
</html>
