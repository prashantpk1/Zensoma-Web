<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalkReminder extends Model
{
    use HasFactory;

     protected $table = "walk_reminders";

     protected $fillable = [
        'user_id',
        'reminder_me_every_day_at',
        'reminder_switch',
    ];

    public function user_detail(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }





}

