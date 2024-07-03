<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;


    protected $table = 'subscriptions';

    protected $fillable = [
        'key',
        'name',
        'image',
        'description',
        'featured',
        'duration',
        'amount',
        'subscription_type',
        'category_id',
        'main_category_id',
        'status',
        'is_delete'
    ];


    protected $casts = [
        'category_id' => 'array',
        'main_category_id' => 'array',
      ];


}
