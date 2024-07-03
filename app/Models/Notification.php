<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';

    protected $fillable = [
        'user_id',
        'notification_type',
        'notification_data',
        'notification_message',
        'is_read',
        'device_type',
        'created_at',
        'updated_at',
    ];
}
