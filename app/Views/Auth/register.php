<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Register | Quizzy</title>
    <link rel="stylesheet" href="<?= base_url('css/auth.css') ?>" />
</head>
<body>

<?php
$errors = session()->getFlashdata('errors') ?? [];
?>

<div class="auth-container">
    <div class="auth-card">
        <h2>Register to Quizzy</h2>

        <form action="<?= base_url('processRegister') ?>" method="post">

            <!-- Username -->
            <div class="input-group">
                <label for="username">Username</label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    placeholder="Masukkan Username"
                    value="<?= old('username') ?>"
                    class="<?= isset($errors['username']) ? 'error' : (old('username') ? 'valid' : '') ?>"
                />
                <?php if(isset($errors['username'])): ?>
                    <small class="error-message"><?= $errors['username'] ?></small>
                <?php endif; ?>
            </div>

            <!-- Email -->
            <div class="input-group">
                <label for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="Masukkan Email"
                    value="<?= old('email') ?>"
                    class="<?= isset($errors['email']) ? 'error' : (old('email') ? 'valid' : '') ?>"
                />
                <?php if(isset($errors['email'])): ?>
                    <small class="error-message"><?= $errors['email'] ?></small>
                <?php endif; ?>
            </div>

            <!-- Password -->
            <div class="input-group">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Masukkan Password"
                    class="<?= isset($errors['password']) ? 'error' : '' ?>"
                />
                <?php if(isset($errors['password'])): ?>
                    <small class="error-message"><?= $errors['password'] ?></small>
                <?php endif; ?>
            </div>

            <!-- Password Confirm -->
            <div class="input-group">
                <label for="password_confirm">Konfirmasi Password</label>
                <input
                    type="password"
                    id="password_confirm"
                    name="password_confirm"
                    placeholder="Konfirmasi Password"
                    class="<?= isset($errors['password_confirm']) ? 'error' : '' ?>"
                />
                <?php if(isset($errors['password_confirm'])): ?>
                    <small class="error-message"><?= $errors['password_confirm'] ?></small>
                <?php endif; ?>
            </div>

            <!-- Role -->
            <div class="input-group">
                <label for="role">Daftar Sebagai</label>
                <select
                    id="role"
                    name="role"
                    class="<?= isset($errors['role']) ? 'error' : (old('role') ? 'valid' : '') ?>"
                >
                    <option value="" disabled <?= old('role') ? '' : 'selected' ?>>Pilih Peran</option>
                    <option value="admin" <?= old('role') == 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="peserta" <?= old('role') == 'peserta' ? 'selected' : '' ?>>Peserta</option>
                </select>
                <?php if(isset($errors['role'])): ?>
                    <small class="error-message"><?= $errors['role'] ?></small>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn">Daftar</button>

            <div class="links">
                <a href="<?= base_url('/login') ?>">Sudah punya akun? Login di sini</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>
