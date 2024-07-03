<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    use HasFactory;

    protected $table= "badges";

    protected $fillable = [
        'badge_name',
        'badge_image',
        'badge_required_minute',
        'badge_required_number_refer',
        'badge_required_challenge',
        'is_delete',
        'status',
        'is_default',
    ];

    protected $casts = [
        'badge_name' => 'array'
      ];







}
