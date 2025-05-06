<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Leaderboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #6a7fdb, #9a5fd1);
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: "Segoe UI", sans-serif;
      margin: 0;
    }

    .leaderboard-container {
      background-color: #2d3362;
      border-radius: 20px;
      padding: 40px;
      color: #fff;
      width: 600px;
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
      animation: fadeIn 0.5s ease-in-out;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(15px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .leaderboard-title {
      text-align: center;
      font-size: 28px;
      margin-bottom: 30px;
    }

    .top-three {
      display: flex;
      justify-content: space-around;
      margin-bottom: 25px;
    }

    .top-user {
      text-align: center;
      transition: transform 0.3s;
    }

    .top-user:hover {
      transform: scale(1.05);
    }

    .top-user img {
      width: 70px;
      height: 70px;
      border-radius: 50%;
      border: 3px solid white;
      margin-bottom: 5px;
    }

    .top-user .score {
      background-color: #555;
      border-radius: 10px;
      padding: 5px 12px;
      color: #ccc;
      font-weight: bold;
      font-size: 14px;
    }

    .user-list {
      background-color: #3b4170;
      border-radius: 10px;
      padding: 10px;
      max-height: 320px;
      overflow-y: auto;
    }

    .user-item {
      display: flex;
      align-items: center;
      padding: 12px;
      border-bottom: 1px solid #4a4f7d;
      transition: background-color 0.2s, transform 0.2s;
      cursor: pointer;
    }

    .user-item:last-child {
      border-bottom: none;
    }

    .user-item:hover {
      background-color: #50568c;
      transform: translateX(5px);
    }

    .user-item img {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      margin-right: 15px;
    }

    .user-rank {
      width: 30px;
      font-weight: bold;
    }

    .user-name {
      flex-grow: 1;
    }

    .user-score {
      color: #ccc;
      font-weight: bold;
    }

    /* Scrollbar style */
    .user-list::-webkit-scrollbar {
      width: 8px;
    }

    .user-list::-webkit-scrollbar-thumb {
      background: #5a60a5;
      border-radius: 4px;
    }
  </style>
</head>
<body>
<?= view('header') ?>
<div class="leaderboard-container">
  <h4 class="leaderboard-title">Leaderboard <br><small class="text-light">Quizzy</small></h4>

  <div class="top-three">
    <div class="top-user">
      <img src="https://via.placeholder.com/70/999999/ffffff?text=1" alt="avatar">
      <div>---</div>
      <div class="score">9000</div>
    </div>
    <div class="top-user">
      <img src="https://via.placeholder.com/70/999999/ffffff?text=2" alt="avatar">
      <div>---</div>
      <div class="score">7500</div>
    </div>
    <div class="top-user">
      <img src="https://via.placeholder.com/70/999999/ffffff?text=3" alt="avatar">
      <div>---</div>
      <div class="score">6000</div>
    </div>
  </div>

  <div class="user-list">
    <?php for ($i = 4; $i <= 15; $i++): ?>
      <div class="user-item">
        <div class="user-rank"><?= $i ?></div>
        <img src="https://via.placeholder.com/40/777777/ffffff?text=?" alt="avatar">
        <div class="user-name">---</div>
        <div class="user-score">0000</div>
      </div>
    <?php endfor; ?>
  </div>
</div>

<?= view('footer') ?>

</body>
</html>
