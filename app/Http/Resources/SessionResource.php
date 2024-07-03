<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Resources\Json\JsonResource;

class SessionResource extends JsonResource
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


        $description_name = json_decode($this->description);
        $description =  $description_name->$language->description;
           return [
            'id' => $this->id,
            'title' => $title ?? "",
            'description' => $description ?? "",
            'file' => URL::to('/public') . '/file/' .$this->session_video_first->video_audio_file,
            'thumbnail_image' => URL::to('/public') . '/thumbnail_image/' .$this->session_video_first->thumbnail_image,
            'level' => $this->level ?? "",
            'type_id' => $this->type_id ?? "",
            'content_type' => $this->content_type,
            'category_id' => $this->category_id ?? "",
            'purchase_type' => $this->purchase_type ?? "",
            'price' => $this->price ?? "",
            'creater_id' => $this->creater_id ?? "",
            'creater_name' => $this->creater_name ?? "",
            'creater_type' => $this->creater_type ?? "",
            'status' => $this->status ?? "",
            'my_favourite' => $this->my_favourite ?? 0,
            'is_available' => $this->is_available ?? 0,
            'created_at' =>  date('Y-M-d h:i A', strtotime($this->created_at)),
            'updated_at' => date('Y-M-d h:i A', strtotime($this->updated_at)),
        ];
    }
}
