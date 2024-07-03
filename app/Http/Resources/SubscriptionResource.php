<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       //get name with  language
        $language =  $request->header('language') ?? "en";
        $sub_name = json_decode($this->name);
        $name =  $sub_name->$language->subscription_name;

        //get description with language
        $sub_des = json_decode($this->description);
        $des =  $sub_des->$language->subscription_description;


        return [
            'id' => $this->id,
            'key' => $this->key,
            'name' => $name,
            'description' => $des,
            'featured' => $this->featured,
            'duration' => $this->duration,
            'amount' => $this->amount,
            'subscription_type' => $this->subscription_type,
            // 'expired_date' => $this->expired_date ?? "",
            'expiry_date' => $this->when($this->expired_date !== null, $this->expired_date),
        ];
    }
}
