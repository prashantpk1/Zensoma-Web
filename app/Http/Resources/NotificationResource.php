<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
           'notification_type' => $this->notification_type,
           'notification_message' => $this->notification_message,
           'is_read' => $this->is_read,
           'created_at' =>  date('Y-M-d h:i A', strtotime($this->created_at)),

        ];
    }
}
