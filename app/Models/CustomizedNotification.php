<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomizedNotification extends Model
{
    use HasFactory;

    protected $table="customized_notifications";

    protected $fillable = [
        "title",
        "content",
        "notification_type",
        "status",
        "is_delete",
    ];

}
