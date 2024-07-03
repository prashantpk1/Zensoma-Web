<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChallengeFriendDetail extends Model
{
    use HasFactory;

    protected $table="challenge_friend_details";

    protected $fillable = [
        "challenge_friend_id",
        "session_video_id",
        "status",
    ];

}
