<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use URL;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {

        $language =  $request->header('language') ?? "en";
        $cate_name = json_decode($this->category_name);
        $name =  $cate_name->$language->category_name;
           return [
            'id' => $this->id,
            'icon' => URL::to('/public') . '/icon/' .$this->icon ?? "",
            'category_image' => URL::to('/public') . '/category_image/' .$this->category_image ?? "",
            'name' => $name,
        ];
    }
}
