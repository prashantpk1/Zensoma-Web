<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryType extends Model
{
    use HasFactory;

    protected $table="category_types";

    protected $fillable = [
        "main_category_id",
        "category_id",
        "type",
        "status",
        "is_delete",
     ];




}
