<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Quiz <?= esc($quizId) ?> - Soal <?= esc($nomor) ?></title>
  <link rel="stylesheet" href="/css/quiz.css" />
  
</head>
<body>

  <div id="timer-container">
  Waktu tersisa: <span id="timer"></span>
</div>


  <h2>Soal <?= esc($nomor) ?>/<?= esc($totalSoal) ?></h2>
  <p class="soal"><?= esc($soal['soal']) ?></p>

  <form id="quiz-form" action="/submit-answer" method="post">
    <input type="hidden" name="quiz_id" value="<?= esc($quizId) ?>">
    <input type="hidden" name="nomor" value="<?= esc($nomor) ?>">
    <input type="hidden" name="jawaban" id="jawaban-hidden">

    <div class="jawaban-grid">
      <button type="button" class="jawaban-button" data-value="a"><?= esc($soal['pilihan_a']) ?></button>
      <button type="button" class="jawaban-button" data-value="b"><?= esc($soal['pilihan_b']) ?></button>
      <button type="button" class="jawaban-button" data-value="c"><?= esc($soal['pilihan_c']) ?></button>
      <button type="button" class="jawaban-button" data-value="d"><?= esc($soal['pilihan_d']) ?></button>
    </div>
  </form>

  <script>
    // Timer logic
    const timerMenit = <?= $timer ?>;
    if (timerMenit > 0) {
      const durasiDetik = timerMenit * 60;
      const startTime = <?= $quiz_start_time ?> * 1000;
      let waktuTersisa = durasiDetik - Math.floor((Date.now() - startTime) / 1000);

      function updateTimer() {
        if (waktuTersisa <= 0) {
          alert("Waktu habis! Quiz akan selesai.");
          window.location.href = "/quiz-selesai";
          return;
        }
        let menit = Math.floor(waktuTersisa / 60);
        let detik = waktuTersisa % 60;
        document.getElementById('timer').textContent = menit + ":" + (detik < 10 ? "0" + detik : detik);
        waktuTersisa--;
      }

      setInterval(updateTimer, 1000);
      updateTimer();
    } else {
      document.getElementById('timer').textContent = "Tidak ada batas waktu";
    }

    // Button click to submit
    document.querySelectorAll('.jawaban-button').forEach(button => {
      button.addEventListener('click', () => {
        const jawaban = button.dataset.value;
        document.getElementById('jawaban-hidden').value = jawaban;
        document.getElementById('quiz-form').submit();
      });
    });
  </script>
</body>
</html>
