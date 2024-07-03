<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PredefinedQuestion extends Model
{
    use HasFactory;


    protected $table = 'predefined_questions';

    protected $fillable = [
        'question',
        'descriptions',
        'option_type',
        'status',
        'is_delete',
        'created_at',
        'updated_at',
    ];

    public function option(){
        return $this->hasMany(Option::class, 'question_id', 'id')->orderBy('option_order','ASC')->orderBy('id','DESC');
    }

}
