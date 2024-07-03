<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GamificationConfig extends Model
{
    use HasFactory;
    protected $table= "gamification_configs";

    protected $fillable = [
        'config_name',
        'config_key',
        'config_value',
        'is_delete',
        'status',
        'is_default',
    ];

    protected $casts = [
        'config_name' => 'array'
      ];

}
