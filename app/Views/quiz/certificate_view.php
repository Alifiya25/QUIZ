<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Sertifikat Pemenang Quiz</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
  <style>
    body {
      background: #f5f7fa;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      padding: 40px 20px;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }
    .certificate-container {
      background: linear-gradient(135deg, #6a7fdb, #9a5fd1);
      width: 700px;
      border-radius: 20px;
      box-shadow: 0 15px 35px rgba(0,0,0,0.2);
      color: #fff;
      padding: 40px 50px;
      text-align: center;
      position: relative;
    }
    .certificate-header {
      font-size: 1.4rem;
      font-weight: 700;
      letter-spacing: 6px;
      margin-bottom: 8px;
      text-transform: uppercase;
      color: #ffd700;
      text-shadow: 1px 1px 5px rgba(255,215,0,0.8);
    }
    .certificate-title {
      font-size: 2.8rem;
      font-weight: 900;
      margin-bottom: 25px;
      text-shadow: 2px 2px 8px rgba(0,0,0,0.4);
    }
    .certificate-body {
      font-size: 1.25rem;
      margin-bottom: 35px;
      line-height: 1.6;
    }
    .certificate-winner {
      font-weight: 700;
      font-size: 2rem;
      margin: 20px 0;
      color: #fff;
      text-shadow: 1px 1px 5px rgba(0,0,0,0.7);
    }
    .certificate-footer {
      font-size: 1rem;
      color: #ddd;
      margin-top: 50px;
      display: flex;
      justify-content: space-between;
      padding: 0 30px;
    }
    .certificate-footer div {
      border-top: 1px solid rgba(255, 255, 255, 0.3);
      padding-top: 10px;
      font-weight: 600;
    }
    .rank-badge {
      position: absolute;
      top: 30px;
      right: 30px;
      background: gold;
      color: #333;
      font-weight: 700;
      font-size: 1.5rem;
      border-radius: 50%;
      width: 70px;
      height: 70px;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 0 10px gold;
      user-select: none;
      text-shadow: none;
    }
    @media (max-width: 768px) {
      .certificate-container {
        width: 90%;
        padding: 30px 20px;
      }
      .certificate-title {
        font-size: 2rem;
      }
      .certificate-winner {
        font-size: 1.5rem;
      }
    }
  </style>
</head>
<body>
  <div class="container d-flex flex-column align-items-center">
    
    <!-- Sertifikat -->
    <div class="certificate-container mb-4" role="main" aria-label="Sertifikat Pemenang Quiz">
      <div class="rank-badge" aria-label="Peringkat">#<?= esc($rank) ?></div>

      <div class="certificate-header">SERTIFIKAT PENGHARGAAN</div>
      <div class="certificate-title">Quiz: <?= esc($quiz_title) ?></div>
      <div class="certificate-body">
        Diberikan kepada<br />
        <span class="certificate-winner"><?= esc($username) ?></span><br />
        atas pencapaian <strong>peringkat ke-<?= esc($rank) ?></strong> dalam quiz ini dengan skor<br />
        <strong><?= esc($score) ?></strong> poin.
      </div>

      <div class="certificate-footer" aria-label="Informasi tambahan sertifikat">
        <div>
          <div>Quizzy Platform</div>
          <small>www.quizzy.com</small>
        </div>
        <div>
          <div>Tanggal</div>
          <small><?= date('d M Y') ?></small>
        </div>
      </div>
    </div>

    <!-- Tombol download (terpisah, bukan di dalam certificate-container) -->
    <button onclick="downloadCertificate()" class="btn btn-warning btn-lg px-5 shadow mb-5">
      Download Sertifikat
    </button>
  </div>

  <script>
    function downloadCertificate() {
      const container = document.querySelector('.certificate-container');
      html2canvas(container).then(canvas => {
        const link = document.createElement('a');
        link.download = 'sertifikat_quiz_<?= esc($username) ?>.png';
        link.href = canvas.toDataURL('image/png');
        link.click();
      });
    }
  </script>
</body>
</html>
