<?php

namespace App\Http\Resources;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Resources\Json\JsonResource;

class FriendResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        $country_data = Country::find($this->received_user_data->country_id);
        return [
          'id' =>$this->received_user_data->id,
          'name' =>$this->received_user_data->name ?? "",
          'country_name' =>$country_data['country_name'] ?? "",
          'profile_image' => URL::to('/public') . '/profile_image/' .$this->received_user_data->profile_image ?? "user.jpg",
          'role' =>$this->received_user_data->role,
        ];
    }
}
