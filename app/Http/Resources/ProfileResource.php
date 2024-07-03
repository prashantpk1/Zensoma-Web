<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name ?? "",
            'profile_image' => URL::to('/public') . '/profile_image/' .$this->profile_image ?? "user.jpg",
            // 'avtar_image' =>URL::to('/public') . '/avtar_image/' .$this->avtar_image ?? "user.jpg",
            'avtar_json' =>$this->avtar_json ?? "",
            'user_type' => $this->user_type,
            'phone' => $this->phone,
            'email' => $this->email,
            'gender' => $this->gender,
            'age' => $this->age,
            'height' => $this->height,
            'weight' => $this->weight,
            'height_value_type' => $this->height_value_type,
            'weight_value_type' => $this->weight_value_type,
            'referral_code' => $this->referral_code,
            'tag_id' => $this->tag_id,
            'drink_water_detail' => $this['drink_water_detail'] ?? "",
            'sleep_detail' => $this['sleep_detail'] ?? "",
            'walk_detail' => $this['walk_detail'] ?? "",
            'user_sleep_last_7_day_record' => $this['user_sleep_detail'] ?? "",
            'created_at' =>  date('Y-M-d h:i A', strtotime($this->created_at)),
            'updated_at' => date('Y-M-d h:i A', strtotime($this->updated_at)),
        ];
    }
}
