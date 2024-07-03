<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Resources\Json\JsonResource;

class AdvertisementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return
        [
            'id' => $this->id,
            'advertisement_image' => URL::to('/public') . '/advertisement_image/' .$this->advertisement_image ?? "",
            'created_at' =>  date('Y-M-d h:i A', strtotime($this->created_at)),

        ];
    }
}
