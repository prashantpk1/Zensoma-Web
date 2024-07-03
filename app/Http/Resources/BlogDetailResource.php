<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
              //get name with  language
              $language =  $request->header('language') ?? "en";
              $title = json_decode($this->title);
              $title_data =  $title->$language->blog_title;

              $sub_title = json_decode($this->sub_title);
              $sub_title_data =  $sub_title->$language->blog_sub_title;

              $description = json_decode($this->description);
              $description_data =  $description->$language->description;
              $cate = json_decode($this->category_name->category_name);
              $category = $cate->$language->category_name ?? "";

              return [
                  'id' => $this->id,
                  'key' => $this->key,
                  'title' => $title_data ?? "",
                  'sub_title' => $sub_title_data ?? "",
                  'description' => $description_data ?? "",
                  'write_name' => $this->create_name->name.".".$category,
                  'image' => URL::to('/public') . '/blog_image/' .$this->image ?? "",
                  'created_at' =>  date('Y-M-d h:i A', strtotime($this->created_at)),
              ];
    }
}
