<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentManagement extends Model
{
    use HasFactory;

    protected $table="content_management";

    protected $fillable = [
        "title",
        "description",
        "file",
        "thumbnail",
        "duration",
        "content_type",
        "main_category_id",
        "category_id",
        "creater_id",
        "creater_name",
        "creater_type",
        // "purchase_type",
        // "price",
        "type_id",
        // "level",
        "status",
        "is_delete",
     ];


     public function category(){
        return $this->hasOne(Categories::class, 'id', 'category_id');
    }

    public function session_video_first(){
        return $this->hasOne(SessionVideos::class, 'session_id', 'id')->where("is_delete",0);
    }


    public function session_videos(){
        return $this->hasMany(SessionVideos::class, 'session_id', 'id')->where("is_delete",0)->orderBy('created_at', 'asc');
    }

    protected $casts = [
        'file' => 'array',
        'thumbnail' => 'array',
      ];


}
