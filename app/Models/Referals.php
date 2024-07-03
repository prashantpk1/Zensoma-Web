<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referals extends Model
{
    use HasFactory;

    protected $table = 'referals';

    protected $fillable = [
        'sender_id',
        'received_id',
    ];

    public function received_user_data(){
        return $this->hasOne(User::class, 'id', 'received_id');
    }


}
