<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="<?= base_url('css/dashboard.css') ?>">
</head>
<body>
<?= view('header') ?>
    <div class="content">
        <div class="header">
            <img src="<?= base_url('/img/LogoQ&A.png') ?>" alt="Logo" class="logo">
            <h1>Welcome to Admin Dashboard, <?= session()->get('username') ?>!</h1>
        </div>
    </div>

    <?= view('footer') ?>
</body>
</html>
