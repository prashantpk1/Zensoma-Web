<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Resources\Json\JsonResource;

class SessionDetailResource extends JsonResource
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
            'duration' => $this->duration." ". "Mins" ?? 0 ,
            'content_type' => $this->content_type ?? "",
            'file' => URL::to('/public') . '/file/' .$this->file,
            'thumbnail_image' => URL::to('/public') . '/thumbnail_image/' .$this->thumbnail,
            'level' => $this->level ?? "",
            'purchase_type' => $this->purchase_type ?? "",
            'price' => $this->price ?? "",
            'category_id' => $this->category_id ?? "",
            'creater_id' => $this->creater_id ?? "",
            'creater_name' => $this->creater_name ?? "",
            'creater_type' => $this->creater_type ?? "",
            'status' => $this->status ?? "",
            'challenge_recived' => $this->challenge_recived ?? 0,
            'challenge_id' => $this->challenge_id ?? 0,
            'challenge_status' => $this->challenge_status ?? 0,
            'my_favourite' => $this->my_favourite ?? 0,
            'is_available' => $this->is_available ?? 0,
            'video_list' => SessionVideoResource::collection($this->session_videos),
            'created_at' =>  date('Y-M-d h:i A', strtotime($this->created_at)),
            'updated_at' => date('Y-M-d h:i A', strtotime($this->updated_at)),
        ];
    }
}
