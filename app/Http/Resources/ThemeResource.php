<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Resources\Json\JsonResource;

class ThemeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $language =  $request->header('language') ?? "en";
        $title_name = json_decode($this->title);
        $title =  $title_name->$language->title;

        return [
            'id' => $this->id,
            'theme_title' => $title,
            'file' => URL::to('/public') . '/file/' .$this->file,
            'thumbnail' => URL::to('/public') . '/thumbnail_image/' .$this->thumbnail,
            'is_default' => $this->is_default,
        ];
    }
}
