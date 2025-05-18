<?php
namespace App\Models;

use CodeIgniter\Model;

class LeaderboardModel extends Model
{
    protected $table = 'leaderboard';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'score']; 
    protected $returnType = 'array';
}
