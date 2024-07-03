<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Resources\Json\JsonResource;

class SessionVideoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $language =  $request->header('language') ?? "en";
          // Decode the JSON string to an associative array
    $video_title = $this->video_title;

    // Access the title_video based on the language, defaulting to empty string if not found
    $title = $video_title[$language]['title_video'] ?? '';

           return [
            'id' => $this->id,
            'session_id' => $this->session_id,
            'video_audio_file' => URL::to('/public') . '/file/' .$this->video_audio_file,
            'thumbnail_image' => URL::to('/public') . '/thumbnail_image/' .$this->thumbnail_image,
            'video_title' => $title,
            'my_session_status' => $this->my_session->status ?? 0,
            'my_session_push_time' => $this->my_session->push_time ?? 0,
            'my_session_minute_spend' => $this->my_session->minute_spend ?? 0,
           ];
    }
}
