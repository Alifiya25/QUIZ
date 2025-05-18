<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Leaderboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background: linear-gradient(135deg, #6a7fdb, #9a5fd1);
      font-family: "Segoe UI", sans-serif;
      margin: 0;
      padding: 40px 0;
      min-height: 100vh;
    }
    .leaderboard-container {
      margin: 50px auto;
      background-color: #2d3362;
      border-radius: 20px;
      padding: 40px;
      color: #fff;
      width: 600px;
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
      animation: fadeIn 0.5s ease-in-out;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(15px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .leaderboard-title {
      text-align: center;
      font-size: 28px;
      margin-bottom: 30px;
      color: white;
    }
    
    /* TOP 3 users styled with grid for proper centering */
    .top-three {
      display: grid;
      grid-template-columns: 1fr 1fr 1fr;
      gap: 30px;
      align-items: end;
      margin-bottom: 25px;
    }
    .top-user {
      text-align: center;
      transition: transform 0.3s;
      cursor: default;
      padding: 10px;
      border-radius: 20px;
      background-color: #3b4170;
      color: #ddd;
    }
    .top-user:hover {
      transform: scale(1.05);
    }
    .top-user img {
      width: 70px;
      height: 70px;
      border-radius: 50%;
      border: 3px solid white;
      margin-bottom: 8px;
      object-fit: cover;
      background-color: #666;
    }
    .top-user .score {
      background-color: #555;
      border-radius: 10px;
      padding: 5px 12px;
      color: #ccc;
      font-weight: bold;
      font-size: 14px;
      margin-top: 5px;
    }
    
    /* Highlight the middle user (rank 1) */
    .top-user.rank-1 {
      grid-column: 2 / 3; /* middle column */
      background-color: #4a4f8c;
      border: 3px solid gold;
      color: #fff;
      transform: scale(1.2);
      box-shadow: 0 0 15px gold;
      z-index: 10;
    }
    /* Rank 2 left column */
    .top-user.rank-2 {
      grid-column: 1 / 2;
    }
    /* Rank 3 right column */
    .top-user.rank-3 {
      grid-column: 3 / 4;
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
      object-fit: cover;
    }
    .user-rank {
      width: 30px;
      font-weight: bold;
      color: #ccc;
      margin-right: 10px;
      text-align: center;
    }
    .user-name {
      flex-grow: 1;
      color: #eee;
    }
    .user-score {
      color: #ccc;
      font-weight: bold;
    }
    /* Scrollbar styling */
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
    <h4 class="leaderboard-title">
      Leaderboard <br />
      <small class="text-light">Quizzy</small>
    </h4>

    <!-- Top 3 Users -->
    <?php
    // Pastikan $topThree berisi user rank 1, 2, 3 secara urut index 0..2
    // Urutkan ulang agar user rank 2, rank 1, rank 3 secara visual (kiri, tengah, kanan)
    $topThreeReordered = [
      $topThree[1], // Rank 2 - kiri
      $topThree[0], // Rank 1 - tengah
      $topThree[2], // Rank 3 - kanan
    ];
    ?>
    <div class="top-three" role="list" aria-label="Top three users">
      <?php foreach ($topThreeReordered as $index => $user): ?>
        <?php 
          // Tentukan kelas rank berdasarkan posisi di $topThree asli
          $originalIndex = array_search($user, $topThree);
          $rankClass = '';
          if ($originalIndex === 0) $rankClass = 'rank-1';
          elseif ($originalIndex === 1) $rankClass = 'rank-2';
          elseif ($originalIndex === 2) $rankClass = 'rank-3';
        ?>
        <div class="top-user <?= $rankClass ?>" title="<?= esc($user['username']) ?>" role="listitem" tabindex="0">
          <img src="https://via.placeholder.com/70/999999/ffffff?text=<?= $originalIndex + 1 ?>" alt="avatar <?= $originalIndex + 1 ?>" />
          <div><?= esc($user['username']) ?></div>
          <div class="score"><?= esc($user['score']) ?></div>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Other Users -->
    <?php if (isset($others) && is_array($others) && count($others) > 0): ?>
      <div class="user-list" role="list" aria-label="Leaderboard other users">
        <?php foreach ($others as $i => $user): ?>
          <div class="user-item" role="listitem" tabindex="0" title="<?= esc($user['username']) ?>">
            <div class="user-rank"><?= $i + 4 ?></div>
            <img src="https://via.placeholder.com/40/777777/ffffff?text=<?= strtoupper(substr($user['username'], 0, 1)) ?>" alt="avatar <?= esc($user['username']) ?>" />
            <div class="user-name"><?= esc($user['username']) ?></div>
            <div class="user-score"><?= esc($user['score']) ?></div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <p class="text-center text-light">No other users found.</p>
    <?php endif; ?>
  </div>

  <?= view('footer') ?>

</body>
</html>
