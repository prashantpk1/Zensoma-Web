<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Resources\Json\JsonResource;

class TagResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $language =  $request->header('language') ?? "en";
        $tag_name = json_decode($this->tag_name);
        $tag_name =  $tag_name->$language->tag_name;

        return [
            'id' => $this->id,
            'tag_name' => $tag_name,
            'file' => URL::to('/public') . '/emoji_icon/' .$this->emoji_icon,
            'status' => $this->status,
        ];
    }
}
