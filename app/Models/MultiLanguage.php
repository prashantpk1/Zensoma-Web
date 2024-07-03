<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MultiLanguage extends Model
{
    use HasFactory;

    protected $table = 'multi_languages';

    protected $fillable = [
        'key',
        'content',
        'status',
        'is_delete'
    ];

}
