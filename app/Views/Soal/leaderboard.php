<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Leaderboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/a2e0f6c59f.js" crossorigin="anonymous"></script>
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
      background: rgba(45, 51, 98, 0.9);
      backdrop-filter: blur(8px);
      border-radius: 20px;
      padding: 40px;
      color: #fff;
      width: 650px;
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
      animation: fadeIn 0.5s ease-in-out;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(15px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .leaderboard-title {
      text-align: center;
      font-size: 32px;
      margin-bottom: 30px;
      color: white;
    }
    .refresh-btn {
      display: flex;
      justify-content: flex-end;
      margin-bottom: 15px;
    }
    .refresh-btn button {
      background-color: #6a7fdb;
      color: #fff;
      border: none;
      padding: 6px 14px;
      border-radius: 8px;
      transition: 0.3s;
    }
    .refresh-btn button:hover {
      background-color: #5d70c9;
    }
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
    .top-user .rank-label {
      margin-top: 4px;
      font-size: 13px;
      color: #aaa;
    }
    .top-user.rank-1 {
      grid-column: 2 / 3;
      background-color: #4a4f8c;
      border: 3px solid gold;
      color: #fff;
      transform: scale(1.2);
      box-shadow: 0 0 15px gold;
      z-index: 10;
    }
    .top-user.rank-2 {
      grid-column: 1 / 2;
    }
    .top-user.rank-3 {
      grid-column: 3 / 4;
    }
    .top-user.rank-1 .rank-label {
      color: gold;
      font-weight: bold;
    }
    .top-user.rank-2 .rank-label {
      color: silver;
      font-weight: bold;
    }
    .top-user.rank-3 .rank-label {
      color: #cd7f32;
      font-weight: bold;
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
    <div class="refresh-btn">
      <form method="GET">
        <button type="submit"><i class="fas fa-sync-alt"></i> Refresh</button>
      </form>
    </div>

    <h4 class="leaderboard-title">
      Leaderboard <br />
      <small class="text-light">Quizzy</small>
    </h4>

    <?php
      $topThreeReordered = [
        $topThree[1] ?? null,
        $topThree[0] ?? null,
        $topThree[2] ?? null,
      ];
    ?>
    <div class="top-three" role="list" aria-label="Top three users">
      <?php foreach ($topThreeReordered as $index => $user): ?>
        <?php 
          if (!$user) continue;
          $originalIndex = array_search($user, $topThree, true);
          $rankClass = '';
          if ($originalIndex === 0) $rankClass = 'rank-1';
          elseif ($originalIndex === 1) $rankClass = 'rank-2';
          elseif ($originalIndex === 2) $rankClass = 'rank-3';
          $avatarUrl = !empty($user['avatar']) ? base_url('uploads/avatars/' . $user['avatar']) : base_url('images/stickman.png');
        ?>
        <div class="top-user <?= $rankClass ?>" title="<?= esc($user['username']) ?>" role="listitem" tabindex="0">
          <img src="<?= esc($avatarUrl) ?>" alt="avatar <?= $originalIndex + 1 ?>" />
          <div><?= esc($user['username']) ?></div>
          <div class="rank-label">Rank <?= $originalIndex + 1 ?></div>
          <div class="score"><?= esc($user['score']) ?></div>
        </div>
      <?php endforeach; ?>
    </div>

    <?php if (isset($others) && is_array($others) && count($others) > 0): ?>
      <div class="user-list" role="list" aria-label="Leaderboard other users">
        <?php foreach ($others as $i => $user): ?>
          <?php $avatarUrl = !empty($user['avatar']) ? base_url('uploads/avatars/' . $user['avatar']) : base_url('images/stickman.png'); ?>
          <div class="user-item" role="listitem" tabindex="0" title="<?= esc($user['username']) ?>">
            <div class="user-rank"><?= $i + 4 ?></div>
            <img src="<?= esc($avatarUrl) ?>" alt="avatar <?= esc($user['username']) ?>" />
            <div class="user-name"><?= esc($user['username']) ?></div>
            <div class="user-score"><?= esc($user['score']) ?></div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <p class="text-center text-light">No other users found.</p>
    <?php endif; ?>

    <!-- Tabel Sertifikat Top 3 -->
    <h5 class="text-white mt-4">Top 3 Sertifikat</h5>
    <table class="table table-dark table-striped table-bordered mt-2">
      <thead>
        <tr>
          <th>#</th>
          <th>Username</th>
          <th>Score</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($topThree as $i => $user): ?>
          <tr>
            <td><?= $i + 1 ?></td>
            <td><?= esc($user['username']) ?></td>
            <td><?= esc($user['score']) ?></td>
            <td>
              <a href="<?= site_url('quiz/sertifikat/' . $quizId . '/' . $user['user_id']) ?>" 
                target="_blank" 
                class="btn btn-success btn-sm">
                Lihat Sertifikat
              </a>
            </td>

          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <?= view('footer') ?>

</body>
</html>
