<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MySession extends Model
{
    use HasFactory;

    protected $table = 'my_sessions';

    protected $fillable = [
        'user_id',
        'session_id',
        'session_video_id',
        'category_id',
        'status',
        'push_time',
        'minute_spend',
    ];

    public function session_data(){
        return $this->hasOne(ContentManagement::class, 'id', 'session_id');
    }

    public function category_name(){
        return $this->hasOne(Categories::class, 'id', 'category_id');
    }



}
