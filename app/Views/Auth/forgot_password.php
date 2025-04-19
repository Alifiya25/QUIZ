<!-- app/Views/auth/forgot_password.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lupa Password | Quizzy</title>
    <link rel="stylesheet" href="<?= base_url('css/auth.css') ?>">
</head>
<body>
<div class="auth-container">
    <div class="auth-card">
        <h2>Lupa Password</h2>
        <p>Masukkan email Anda untuk mereset password.</p>

        <form method="post" action="<?= base_url('forgot-password') ?>">
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" name="email" required placeholder="Masukkan email Anda">
            </div>
            <button class="btn" type="submit">Kirim Link Reset</button>
        </form>

        <div class="links">
            <a href="<?= base_url('login') ?>">Kembali ke Login</a>
        </div>
    </div>
</div>
</body>
</html>
