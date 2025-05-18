<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Quiz Ready</title>
    <link rel="stylesheet" href="<?= base_url('css/quiz_ready.css') ?>" />
</head>
<body>
    <div class="quiz-container">
        <h2>Quiz: <?= session()->get('quiz_title') ?></h2>
        <p>Tekan tombol mulai untuk memulai quiz.</p>
        <a href="<?= base_url('quiz-show/' . session()->get('quiz_id')) ?>" class="btn-start">Mulai Quiz</a>
    </div>
</body>
</html>
