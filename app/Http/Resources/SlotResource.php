<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\SlotDetailResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SlotResource extends JsonResource
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
                'start_time' => $this->start_time,
                'end_time' => $this->end_time,
                'duration' => $this->duration,
                'is_available' => $this->is_available ?? "",
                'created_at' =>  date('Y-M-d h:i A', strtotime($this->created_at)),
                'updated_at' => date('Y-M-d h:i A', strtotime($this->updated_at)),

        ];
    }
}
