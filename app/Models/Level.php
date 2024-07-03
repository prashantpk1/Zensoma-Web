<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $table = 'levels';

    protected $fillable = [
        'level_name',
        'level_munite_start',
        'level_munite_end',
        'is_delete',
        'status',
        'is_default',
    ];


    protected $casts = [
        'level_name' => 'array'
      ];
}
