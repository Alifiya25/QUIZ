<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register | Quizzy</title>
    <link rel="stylesheet" href="css/auth.css">
</head>
<body>

<div class="auth-container">
    <div class="auth-card">
        <h2>Register to Quizzy</h2>

        <!-- Menampilkan pesan status -->
        <?php if(session()->getFlashdata('success')): ?>
            <div class="success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php elseif(session()->getFlashdata('warning')): ?>
            <div class="warning">
                <?= session()->getFlashdata('warning') ?>
            </div>
        <?php endif; ?>

        <!-- Form registrasi -->
        <form method="post" action="<?= base_url('/processRegister') ?>">
            <?= csrf_field() ?>
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Masukkan Username" value="<?= old('username') ?>" required>
            </div>
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Masukkan Email" value="<?= old('email') ?>" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Masukkan Password" required>
            </div>
            <div class="input-group">
                <label for="password_confirm">Confirm Password</label>
                <input type="password" id="password_confirm" name="password_confirm" placeholder="Konfirmasi Password" required>
            </div>
            <div class="input-group">
                <label for="role">Daftar Sebagai</label>
                <select id="role" name="role" required>
                    <option value="" disabled selected>Pilih Peran</option>
                    <option value="admin" <?= old('role') == 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="peserta" <?= old('role') == 'peserta' ? 'selected' : '' ?>>Peserta</option>
                </select>
            </div>
            <button class="btn" type="submit">Register</button>
        </form>

        <div class="links">
            <a href="/login">Already have an account? Login here</a>
        </div>
    </div>
</div>

</body>
</html>
