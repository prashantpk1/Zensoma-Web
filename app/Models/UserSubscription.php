<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model
{
    use HasFactory;

    protected $table="user_subscriptions";

    protected $fillable = [
        "user_id",
        "transaction_id",
        "subscription_id",
        "plan_duration",
        "status",
        "start_date",
        "end_date",
    ];

    public function subscription(){
        return $this->hasOne(Subscription::class, 'id', 'subscription_id');
    }


    public function user_data(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }


}
