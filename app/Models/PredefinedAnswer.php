<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PredefinedAnswer extends Model
{
    use HasFactory;

    protected $table="predefined_answers";

    protected $fillable = [
        'user_id',
        'answers',
    ];

}
