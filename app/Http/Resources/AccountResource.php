<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
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
            'avtar_image' =>$this->avtar_image,
            'user_type' => $this->user_type,
            'phone' => $this->phone,
            'email' => $this->email,
            'gender' => $this->gender,
            'referral_code' => $this->referral_code,
            'country_id' => $this->country_id ?? 0,
            'device_type' => $this->device_type ?? "",
            'fmc_token' => $this->fcm_token ?? "",
            'is_predefined_submit' => $this->is_predefined_submit ?? 0,
            'created_at' =>  date('Y-M-d h:i A', strtotime($this->created_at)),
            'updated_at' => date('Y-M-d h:i A', strtotime($this->updated_at)),
            'token' => $this->token,
        ];
    }
}
