<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title><?= $title ?? 'Aplikasi' ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- CSS Utama -->
  <link rel="stylesheet" href="<?= base_url('css/layout.css') ?>">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    .dropdown-avatar {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid #eee;
      transition: box-shadow 0.2s ease;
    }

    .dropdown-avatar:hover {
      box-shadow: 0 0 0 2px #3085d6;
    }

    .dropdown-avatar-large {
      width: 72px;
      height: 72px;
      border-radius: 50%;
      object-fit: cover;
      margin-bottom: 12px;
      border: 3px solid #eee;
    }

    .user-nav ul li.dropdown {
      position: relative;
    }

    .profile-dropdown {
      display: block;
      opacity: 0;
      visibility: hidden;
      position: absolute;
      top: 52px;
      right: 0;
      background: #fff;
      border-radius: 12px;
      padding: 20px 15px;
      z-index: 1000;
      width: 240px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
      text-align: center;
      transition: all 0.25s ease;
      transform: translateY(10px);
    }

    .profile-dropdown.show {
      opacity: 1;
      visibility: visible;
      transform: translateY(0);
    }

    .user-info {
      margin-bottom: 14px;
    }

    .user-info strong {
      display: block;
      font-size: 16px;
      margin-bottom: 4px;
      color: #333;
    }

    .user-info p {
      margin: 0;
      font-size: 13px;
      color: #666;
    }

    .user-info small {
      display: block;
      margin-top: 6px;
      font-size: 12px;
      color: #999;
    }

    .user-nav .btn {
      margin-left: 20px;
    }

    input[type="file"] {
      margin-top: 12px;
      display: block;
      margin-left: auto;
      margin-right: auto;
    }

    .profile-dropdown button[type="submit"] {
      background: #3085d6;
      color: #fff;
      border: none;
      padding: 8px 14px;
      border-radius: 6px;
      cursor: pointer;
      transition: background 0.2s ease;
      margin-top: 8px;
    }

    .profile-dropdown button[type="submit"]:hover {
      background: #256abf;
    }
  </style>
</head>

<body>

  <?php $avatar = session()->get('avatar') ?? 'default-avatar.png'; ?>

  <header>
    <div class="header-container">
      <div class="hamburger">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
      </div>

      <div class="header-spacer"></div>

      <div class="user-nav">
        <ul>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle">
              <img src="<?= base_url('uploads/avatars/' . $avatar) ?>" alt="Avatar" class="dropdown-avatar">
              <i class="fas fa-caret-down"></i>
            </a>
            <div class="profile-dropdown" id="profileDropdown">
              <img src="<?= base_url('uploads/avatars/' . $avatar) ?>" alt="Avatar" class="dropdown-avatar-large">
              <div class="user-info">
                <strong><?= session()->get('nama') ?? 'User' ?></strong>
                <p><?= session()->get('email') ?? 'email@domain.com' ?></p>
                <small style="color: #333;">Role: <?= session()->get('role') ?: 'Guest' ?></small>
              </div>
              <form action="<?= base_url('profile/uploadAvatar') ?>" method="post" enctype="multipart/form-data">
                <input type="file" name="avatar" accept="image/*" required>
                <button type="submit">Upload Foto</button>
              </form>
            </div>
          </li>
          <li>
            <a href="#" class="btn" id="logoutBtn"><i class="fas fa-sign-out-alt"></i> Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </header>

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
          <li><a href="<?= base_url('/admin/about_us') ?>"><i class="fas fa-info-circle"></i> About Us</a></li>
        <?php elseif (session()->get('role') == 'peserta'): ?>
          <li><a href="<?= base_url('/dashboard/peserta') ?>"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
          <li><a href="<?= base_url('/admin/about_us') ?>"><i class="fas fa-info-circle"></i> About Us</a></li>
        <?php endif; ?>
      </ul>
    </nav>
  </aside>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      // Toggle Sidebar
      document.querySelector(".hamburger").addEventListener("click", toggleSidebar);

      // Toggle Profile Dropdown menggunakan SweetAlert
      document.querySelector(".dropdown-toggle").addEventListener("click", toggleProfileDropdown);

      // Logout Confirmation
      document.getElementById("logoutBtn").addEventListener("click", confirmLogout);

      // Close Dropdown jika klik di luar (tidak diperlukan jika modal SweetAlert)
    });

    function toggleSidebar() {
      document.getElementById('sidebar').classList.toggle('active');
    }

    function toggleProfileDropdown(event) {
      event.preventDefault();
      event.stopPropagation();

      const avatar = "<?= base_url('uploads/avatars/' . $avatar) ?>";
      const nama = "<?= session()->get('nama') ?? 'User' ?>";
      const email = "<?= session()->get('email') ?? 'email@domain.com' ?>";
      const role = "<?= session()->get('role') ?: 'Guest' ?>";

      Swal.fire({
        title: nama,
        html: `
        <img src="${avatar}" alt="Avatar" style="width:72px;height:72px;border-radius:50%;margin-bottom:12px;border:2px solid #eee;">
        <p style="margin:0;">${email}</p>
        <small style="display:block;margin-top:6px;color:#666;">Role: ${role}</small>
        <form id="avatarUploadForm" enctype="multipart/form-data">
          <input type="file" name="avatar" accept="image/*" style="margin-top:12px;" required />
          <button type="submit" class="swal2-confirm swal2-styled" style="margin-top:10px;background:#3085d6;">Upload Foto</button>
        </form>
      `,
        showCloseButton: true,
        showConfirmButton: false,
        didOpen: () => {
          const form = document.getElementById('avatarUploadForm');
          form.addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            try {
              const response = await fetch("<?= base_url('profile/uploadAvatar') ?>", {
                method: "POST",
                body: formData
              });
              const result = await response.json();

              if (result.status === 'success') {
                Swal.fire({
                  icon: 'success',
                  title: 'Berhasil',
                  text: result.message
                });

                // Update avatar di modal dan dropdown
                // Cari gambar avatar di SweetAlert dan update src
                const swalContent = Swal.getHtmlContainer();
                if (swalContent) {
                  const imgInModal = swalContent.querySelector('img');
                  if (imgInModal) imgInModal.src = result.avatar;
                }

                // Update avatar dropdown (gambar kecil di navbar)
                const avatarSmall = document.querySelector('.dropdown-avatar');
                if (avatarSmall) avatarSmall.src = result.avatar;

              } else {
                Swal.fire({
                  icon: 'error',
                  title: 'Gagal',
                  text: result.message
                });
              }
            } catch (error) {
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Terjadi kesalahan saat mengupload.'
              });
            }
          });
        }
      });
    }

    function confirmLogout(e) {
      e.preventDefault();
      Swal.fire({
        title: 'Yakin ingin logout?',
        text: "Sesi kamu akan diakhiri.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, logout',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = "<?= base_url('logout') ?>";
        }
      });
    }
  </script>


  <?php if (session()->getFlashdata('success')): ?>
    <script>
      Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: '<?= session()->getFlashdata('success') ?>',
        showConfirmButton: true,
        // timer: 2500,  
      });
    </script>
  <?php elseif (session()->getFlashdata('error')): ?>
    <script>
      Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: '<?= session()->getFlashdata('error') ?>',
        showConfirmButton: true,
        // timer: 2500,
      });
    </script>
  <?php endif; ?>



</body>

</html>