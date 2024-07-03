<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Resources\Json\JsonResource;

class BuddyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $country_data = Country::find($this->user_data->country_id);


        $createdAt = Carbon::parse($this->created_at);

        // Check if the created_at date is within the last 24 hours
        if ($createdAt->greaterThanOrEqualTo(Carbon::now()->subHours(24))) {
            // Created within the last 24 hours
            $type = "New";
        } else {
            // Created more than 24 hours ago
            $type = "Old";
        }


        return [
                   'buddy_network_id' => $this->id,
                   'user_id' => $this->user_data->id,
                   'user_name' => $this->user_data->name,
                   'conutry_name' => $country_data['country_name'] ?? "",
                   'profile_image' => URL::to('/public') . '/profile_image/' .$this->user_data->profile_image ?? "user.jpg",
                   'label' => $type,
        ];
    }
}
