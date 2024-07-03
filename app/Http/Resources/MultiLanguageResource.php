<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MultiLanguageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $language =  $request->header('language') ?? "en";

        $content_array = json_decode($this->content);
        $content =  $content_array->$language->content;
        return [
            'id' => $this->id,
            'key' => $this->key ?? "",
            'content' => $content ?? "",
        ];
    }
}
