<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrinkWaterReminder extends Model
{
    use HasFactory;

    protected $table = 'drink_water_reminders';

    protected $fillable = [
        'user_id',
        'reminder_start_time',
        'reminder_end_time',
        'reminder_type',
        'remind_me_every_hour_number',
        'remind_me_every_hour',
        'reminder_me_every_day_at',
        'reminder_switch',
    ];

    public function user_detail(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }



    protected $casts = [
        'remind_me_every_hour' => 'array'
      ];





}
