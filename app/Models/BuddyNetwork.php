<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuddyNetwork extends Model
{
    use HasFactory;

    protected $table="buddy_networks";

    protected $fillable = [
        "user_id",
        "referral_code",
        "number_of_refer",
        "status",
        "is_delete"
    ];

    public function user_data(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }







}
