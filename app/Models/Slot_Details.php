<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slot_Details extends Model
{
    use HasFactory;


    protected $table = 'slot__details';

    protected $fillable = [
        'slot_id',
        'start_time',
        'end_time',
        'duration',
        'is_available',
        'is_available_update_at',
    ];

    public function slot_info(){
        return $this->hasOne(Slot::class, 'id', 'slot_id');
    }
}
