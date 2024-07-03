<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Resources\Json\JsonResource;

class MySessionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $language =  $request->header('language');
        $title_name = json_decode($this->session_data->title);
        $title =  $title_name->$language->title;
      return [
            'id' => $this->id,
            'status' => $this->status,
            // 'push_time' => $this->push_time,
            'session_id' => $this->session_data->id,
            'content_type' => $this->session_data->content_type,
            'title' => $title ?? "",
            'file' => URL::to('/public') . '/file/' .$this->session_data->file,
            'thumbnail_image' => URL::to('/public') . '/thumbnail_image/' .$this->session_data->thumbnail ?? "",
            'category_id' => $this->session_data->category_id ?? "",
            'creater_id' => $this->session_data->creater_id ?? "",
            'creater_name' => $this->session_data->creater_name ?? "",
            'creater_type' => $this->session_data->creater_type ?? "",
            'status_session' => $this->session_data->status ?? "",
            'created_at' =>  date('Y-M-d h:i A', strtotime($this->session_data->created_at)),
            'updated_at' => date('Y-M-d h:i A', strtotime($this->session_data->updated_at)),
        ];
    }
}
