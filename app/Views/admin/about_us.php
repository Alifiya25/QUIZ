<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title><?= esc($title) ?? 'Tentang Quizzy' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- AOS (Animation on Scroll) -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/about_us.css') ?>">
</head>

<body>
    <?= view('header') ?>
    <div class="container py-5">
        <div class="card card-custom p-4" data-aos="fade-up">
            <h1 class="text-center mb-4 section-title">Tentang <span class="text-primary">Quizzy</span></h1>

            <p class="lead text-center mb-5">
                <strong>Quizzy</strong> adalah platform kuis online interaktif yang dirancang untuk mendukung pembelajaran dan evaluasi secara digital. Dikembangkan oleh mahasiswa Universitas Jenderal Achmad Yani dalam rangka tugas besar Teknologi Web.
            </p>

            <div class="row mb-4">
                <div class="col-md-6" data-aos="fade-right">
                    <h4 class="section-title"><i class="bi bi-flag icon"></i>Tujuan Aplikasi</h4>
                    <ul>
                        <li>Menyediakan kuis online untuk pembelajaran dan pelatihan</li>
                        <li>Evaluasi interaktif berbasis digital</li>
                        <li>Memberi kemudahan dalam pembuatan dan penilaian soal</li>
                    </ul>
                </div>
                <div class="col-md-6" data-aos="fade-left">
                    <h4 class="section-title"><i class="bi bi-star icon"></i>Fitur Unggulan</h4>
                    <ul>
                        <li>Dashboard Admin & Peserta</li>
                        <li>Input soal berbagai jenis</li>
                        <li>Penilaian otomatis & rekap nilai</li>
                        <li>Leaderboard & gamifikasi</li>
                    </ul>
                </div>
            </div>

            <div data-aos="fade-up">
                <h4 class="section-title"><i class="bi bi-people icon"></i>Tim Pengembang</h4>
                <div class="row">
                    <?php
                    $tim = [
                        ['nama' => 'Arjuna Sakti', 'nim' => '2250081133'],
                        ['nama' => 'Mochamad Vikry Firdaus', 'nim' => '2250081139'],
                        ['nama' => 'Fanesa Fortuna Fantri', 'nim' => '2250081149'],
                        ['nama' => 'Alifiya Seftika Putri', 'nim' => '2250081165'],
                        ['nama' => 'Eny Retno Wijayanti', 'nim' => '2250081169'],
                    ];
                    foreach ($tim as $anggota): ?>
                        <div class="col-md-6">
                            <div class="developer-card"><strong><?= $anggota['nama'] ?></strong> – <?= $anggota['nim'] ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="mt-4 text-center" data-aos="fade-up">
                <h5><i class="bi bi-envelope icon"></i>Hubungi Kami</h5>
                <p>Untuk informasi lebih lanjut, silakan hubungi kami di <a href="mailto:quizzy.support@gmail.com">quizzy.support@gmail.com</a></p>
            </div>

            <div class="text-center mt-4">
                <?php 
                   $dashboardUrl =  ($role === 'admin') ? base_url('/dashboard/admin'): base_url('/dashboard/peserta')
                ?>
                <a href="<?= $dashboardUrl ?>" class="btn btn-primary">Masuk ke Dashboard</a>
            </div>
        </div>
    </div>
    <?= view('footer') ?>

    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>