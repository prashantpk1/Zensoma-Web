<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table="transactions";

    protected $fillable = [
        "user_id",
        "payment_mode",
        "transaction_type",
        "subscription_id",
        "session_id",
        "amount",
        "status",
    ];


    public function user_data(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }


    public function session(){
        return $this->hasOne(ContentManagement::class, 'id', 'session_id');
    }

}
