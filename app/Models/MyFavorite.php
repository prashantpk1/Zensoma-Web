<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MyFavorite extends Model
{
    use HasFactory;

    protected $table = 'my_favorites';

    protected $fillable = [
        'user_id',
        'session_id',
        'is_delete',
    ];


    public function MySession(){
        return $this->hasOne(ContentManagement::class, 'id', 'session_id')->where('is_delete',0);
    }

}

