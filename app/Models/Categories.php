<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;

    protected $table="categories";

    protected $fillable = [
        "is_parent",
        "category_name",
        "icon",
        "category_image",
        "status",
        "is_delete",
     ];

     public function contentManagements()
    {
        return $this->hasMany(ContentManagement::class);
    }



}
