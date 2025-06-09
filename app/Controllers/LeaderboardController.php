<?php

namespace App\Controllers;

use App\Models\LeaderboardModel;

class LeaderboardController extends BaseController
{
    public function index()
    {
        $model = new LeaderboardModel();

        $topThree = $model->select('leaderboard.score, users.username')
            ->join('users', 'users.id = leaderboard.user_id')
            ->orderBy('score', 'DESC')
            ->limit(3)
            ->findAll();

        $others = $model->select('leaderboard.score, users.username')
            ->join('users', 'users.id = leaderboard.user_id')
            ->orderBy('score', 'DESC')
            ->findAll(100, 3); // skip 3 teratas

        return view('leaderboard', [
            'topThree' => $topThree,
            'others' => $others,
        ]);
    }
}
