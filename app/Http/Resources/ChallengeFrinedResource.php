<?php

namespace App\Http\Resources;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Resources\Json\JsonResource;

class ChallengeFrinedResource extends JsonResource
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

        $country_name_sender = Country::find($this->user_challenge_from->country_id);
        $country_name_reciever = Country::find($this->user_challenge_to->country_id);
      return [
            'id' => $this->id,
            'challenge_status' => $this->status,
            'is_available' => $this->is_available,  
            'session_id' => $this->session_data->id,
            'content_type' => $this->session_data->content_type,
            'title' => $title ?? "",
            'file' => URL::to('/public') . '/file/' .$this->session_data->file,
            'thumbnail_image' => URL::to('/public') . '/thumbnail_image/' .$this->session_data->thumbnail ?? "",
            'category_id' => $this->session_data->category_id ?? "",
            'creater_id' => $this->session_data->creater_id ?? "",
            'creater_name' => $this->session_data->creater_name ?? "",
            'creater_type' => $this->session_data->creater_type ?? "",
            'status' => $this->session_data->status ?? "",
            'sender_data_user_id' => $this->user_challenge_from->id ?? "",
            'sender_data_user_name' => $this->user_challenge_from->name ?? "",
            'sender_data_user_profile_image' => URL::to('/public') . '/profile_image/' .$this->user_challenge_from->profile_image ?? "user.jpg",
            'sender_data_user_country' => $country_name_sender->country_name ?? "country not found",
            'reciever_data_user_id' => $this->user_challenge_to->id ?? "",
            'reciever_data_user_name' => $this->user_challenge_to->name ?? "",
            'reciever_data_user_profile_image' => URL::to('/public') . '/profile_image/' .$this->user_challenge_to->profile_image ?? "user.jpg",
            'reciever_data_user_country' => $country_name_reciever->country_name  ?? "country not found",
            'created_at' =>  date('Y-M-d h:i A', strtotime($this->session_data->created_at)),
            'updated_at' => date('Y-M-d h:i A', strtotime($this->session_data->updated_at)),
        ];
    }
}
