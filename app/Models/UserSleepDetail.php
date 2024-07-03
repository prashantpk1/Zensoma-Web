<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSleepDetail extends Model
{
    use HasFactory;

    protected $table = "user_sleep_details";

    protected $fillable = [
        'user_id',
        'sleep_start_date',
        'sleep_end_date',
        'sleep_start_time',
        'sleep_end_time',
        'duration',
        'sleep_log',
    ];

}
