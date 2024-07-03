<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $table = "tags";

    protected $fillable = [
        'tag_name',
        'emoji_icon',
        'status',
        'is_delete',
    ];


    protected $casts = [
        'tag_name' => 'array',
    ];

}
