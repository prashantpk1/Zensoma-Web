<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SleepReminder extends Model
{
    use HasFactory;

    protected $table = "sleep_reminders";

    protected $fillable = [
       'user_id',
       'start_time_switch',
       'start_time',
       'end_time_switch',
       'end_time',
   ];


   public function user_detail()
   {
    return $this->hasOne(User::class, 'id','user_id');
   }

}
