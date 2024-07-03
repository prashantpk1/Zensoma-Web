<?php

namespace App\Http\Resources;

use App\Models\Slot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Resources\Json\JsonResource;

class MyBookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

      $price = Slot::find($this->Slot_Details->slot_id);
        return [
            'id' => $this->id,
            'transaction_id' => $this->transaction_id,
            'therapist_id' => $this->therapist_id,
            'therapist_name' => $this->therapist_data->name,
            'therapist_designation' => $this->therapist_data->designation,
            'therapist_profile_image' => URL::to('/public') . '/profile_image/' .$this->therapist_data->profile_image ?? "",
            'user_id' => $this->user_id,
            'date' => $this->date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'slot_id' => $this->slot_id,
            'amount' => $price->price_per_slot ?? 0,
            'status' => $this->status,
            'meeting_id' => $this->meeting_id,
            'meeting_password' => $this->meeting_password,
            'meeting_api_response' => $this->meeting_response,
            'booking_at' =>  date('Y-M-d h:i A', strtotime($this->created_at)),
            'created_at' =>  date('Y-M-d h:i A', strtotime($this->created_at)),
            'updated_at' => date('Y-M-d h:i A', strtotime($this->updated_at))
        ];
    }
}
