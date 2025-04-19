<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login | Quizzy</title>
    <link rel="stylesheet" href="css/auth.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>

<div class="auth-container">
    <div class="auth-card">
        <h2>Login to Quizzy</h2>

        <form method="post" action="<?= base_url('/processLogin') ?>">
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Masukkan Email" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Masukkan Password" required>
            </div>
            <button class="btn" type="submit">Login</button>
        </form>

        <!-- Google Sign In Button -->
        <div class="google-btn">
            <a href="/google-redirect" class="google-signin-btn">
                <i class="fab fa-google"></i> Sign in with Google
            </a>
        </div>

        <div class="links">
            <a href="/register">Register</a> |
            <a href="/forgot-password">Forgot Password?</a>
        </div>
    </div>
</div>

<script src="https://apis.google.com/js/platform.js" async defer></script>

</body>
</html>
