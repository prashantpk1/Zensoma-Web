<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $table = "bookings";

    protected $fillable = [
        "transaction_id",
        "therapist_id",
        "user_id",
        "date",
        "start_time",
        "end_time",
        "slot_id",
        "is_live",
        "token",
        "session_token",
        "session_name",
        "meeting_id",
        "meeeting_password",
        "meeting_response",
        "status",
        "is_delete",
    ];


    public function user_data(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }


    public function therapist_data(){
        return $this->hasOne(User::class, 'id', 'therapist_id');
    }


    public function transaction(){
        return $this->hasOne(Transaction::class, 'id', 'transaction_id');
    }

    public function Slot_Details(){
        return $this->hasOne(Slot_Details::class, 'id', 'slot_id');
    }







}
