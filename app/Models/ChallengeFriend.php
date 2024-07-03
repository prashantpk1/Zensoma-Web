<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChallengeFriend extends Model
{
    use HasFactory;

    protected $table="challenge_friends";

    protected $fillable = [
        "session_id",
        "challenge_from",
        "challenge_to",
        "status",
    ];


    public function session_data(){
        return $this->hasOne(ContentManagement::class, 'id', 'session_id');
    }

    public function user_challenge_from(){
        return $this->hasOne(User::class, 'id', 'challenge_from')->select('id','name','profile_image','country_id');
    }

    public function user_challenge_to(){
        return $this->hasOne(User::class, 'id', 'challenge_to')->select('id','name','profile_image','country_id');
    }





}
