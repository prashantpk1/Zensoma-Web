<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    use HasFactory;


    protected $table = 'slots';

    protected $fillable = [
        'user_id',
        'title',
        'category_id',
        'date',
        'price_per_slot',
        'is_draft',
        'date',
        'status',
        'is_delete',
    ];

    public function slot_details(){
        return $this->hasMany(Slot_Details::class, 'slot_id', 'id');
    }


    public function slot_details1(){
        return $this->hasMany(Slot_Details::class, 'slot_id', 'id')->select('id as id','slot_id','start_time','end_time','duration','is_available');
    }








}
