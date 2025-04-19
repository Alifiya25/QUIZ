<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="<?= base_url('css/auth.css') ?>">
    <title>Reset Password</title>
</head>
<body>
<div class="auth-container">
    <div class="auth-card">
        <h2>Reset Password</h2>
        <p>Masukkan password baru untuk akun Anda.</p>

        <form method="POST" action="<?= base_url('reset-password') ?>">
            <?= csrf_field() ?>
            <input type="hidden" name="emailHash" value="<?= $emailHash ?>">

            <div class="input-group">
                <label for="password">Password Baru</label>
                <input type="password" name="password" id="password" placeholder="Masukkan password baru" required>
            </div>

            <button type="submit" class="btn">Reset Password</button>
        </form>

        <div class="links">
            <a href="<?= base_url('login') ?>">Kembali ke Login</a>
        </div>
    </div>
</div>
</body>
</html>
