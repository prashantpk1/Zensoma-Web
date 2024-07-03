<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
    use HasFactory;

    protected $table = "user_details";

    protected $fillable = [
        'user_id',
        'total_refer_count',
        'total_challenge_complate_count',
        'total_minute_spend',
        'current_level_id',
        'badge_ids',
    ];


    protected $casts = [
        'badge_ids' => 'array'
      ];
}
