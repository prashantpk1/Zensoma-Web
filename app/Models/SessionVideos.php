<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionVideos extends Model
{
    use HasFactory;

    protected $table = 'session_videos';

    protected $fillable = [
        'sender_id',
        'video_title',
        'thumbnail_image',
        'video_audio_file',
        'status',
        'is_delete',
    ];

    protected $casts = [
        'video_title' => 'array',
    ];

}
