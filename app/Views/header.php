<link rel="stylesheet" href="<?= base_url('css/layout.css') ?>">
<!-- Font Awesome CDN, taruh di dalam <head> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<header>
    <div class="header-container">
        <!-- Kiri: Hamburger -->
        <div class="hamburger" onclick="toggleSidebar()">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
        </div>
        <!-- TENGAH: Judul atau kosong -->
        <div class="header-spacer"></div>

        <!-- Kanan: Profile & Logout -->
        <div class="user-nav">
            <ul>
                <li><a href="<?= base_url('profile') ?>"><i class="fas fa-user"></i></a></li>
                <li><a href="<?= base_url('logout') ?>"><i class="fas fa-sign-out-alt"></i></a></li>
            </ul>
        </div>
    </div>

    <!-- Sidebar -->
    <aside id="sidebar">
        <nav>
            <ul>
                <?php if (session()->get('role') == 'admin'): ?>
                    <li><a href="<?= base_url('/dashboard/admin') ?>"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li><a href="<?= base_url('soal') ?>"><i class="fas fa-archive"></i> Gudang Soal</a></li>
                    <li><a href="<?= base_url('soal/list_quiz') ?>"><i class="fas fa-list-ul"></i> List Quiz</a></li>
                    <li><a href="<?= base_url('admin/daftar_peserta') ?>"><i class="fas fa-users"></i> Manajemen Peserta</a></li>
                    <li><a href="<?= base_url('admin/daftar_admin') ?>"><i class="fas fa-user-cog"></i> Manajemen Admin</a></li>
                    <li><a href="<?= base_url('quiz/hasil_quiz') ?>"><i class="fas fa-trophy"></i> Hasil Quiz</a></li>
                    <li><a href="<?= base_url('/admin/about_us'); ?>"><i class="fas fa-info-circle"></i> About Us</a></li>
                <?php endif; ?>
                <?php if (session()->get('role') == 'peserta'): ?>
                    <li><a href="<?= base_url('/dashboard/peserta') ?>"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li><a href="<?= base_url('peserta/tasks') ?>"><i class="fas fa-certificate"></i> Sertifikat</a></li>
                    <li><a href="<?= base_url('/admin/about_us'); ?>"><i class="fas fa-info-circle"></i> About Us</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </aside>
</header>
<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('active');
    }
</script>