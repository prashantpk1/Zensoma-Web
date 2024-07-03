<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    // use HasTranslations;

    protected $table="blogs";

    protected $fillable = [
        "key",
        "image",
        "category_id",
        "title",
        "status",
        "language",
        "sub_title",
        "is_delete",
        "description",
        "created_by",
    ];


    public function category_name(){
        return $this->hasOne(Categories::class, 'id', 'category_id');
    }

    public function create_name(){
        return $this->hasOne(User::class, 'id', 'created_by');
    }




}
