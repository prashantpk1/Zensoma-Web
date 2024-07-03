<?php

namespace App\Http\Resources;

use DateTime;
use DateTimeZone;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Resources\Json\JsonResource;

class BuddySessionDetailResource extends JsonResource
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

        //get  category name
       $category_array =  json_decode($this->session_data->category_id);
       if($category_array){
       $category_id = $category_array[0];

                  if($category_id)
                  {
                    $category = Categories::find($category_id);

                    $language =  $request->header('language');
                    $category_name_new = json_decode($category->category_name);
                    $category_name =  $category_name_new->$language->category_name;

                  }
                  else
                  {
                    $category_name = "";
                  }

       }
       else
       {
        $category_name = "";
       }

       //for new and old
       $createdAtDateTime = new DateTime($this->created_at, new DateTimeZone('UTC')); // Assuming the timestamps are in UTC

        $currentDateTime = new DateTime('now', new DateTimeZone('UTC'));

        $interval = $currentDateTime->diff($createdAtDateTime);

        if ($interval->d >= 1) {
           $label = "Old";
        } else {
            $label = "New";
        }

        return [
            'session_id' => $this->session_data->id ?? "",
            'file' => URL::to('/public') . '/file/' .$this->session_data->file,
            'thubmnail_image' => URL::to('/public') . '/thumbnail_image/' .$this->session_data->thumbnail,
            'title' => $title ?? "",
            'label' => $label ?? "",
            'status' => $this->status ?? "",
            'push_time' => $this->push_time ?? "",
            'category_name' => $category_name ?? "",
            'content_type' => $this->session_data->content_type ?? "",
            'creater_id' => $this->session_data->creater_id ?? "",
            'creater_name' => $this->session_data->creater_name ?? "",
            'creater_type' => $this->session_data->creater_type ?? "",
            'created_at' =>  date('Y-M-d h:i A', strtotime($this->session_data->created_at)),
            'updated_at' => date('Y-M-d h:i A', strtotime($this->session_data->updated_at)),
        ];
        $category_id = "";
        $category_name = "";
        $category = "";
    }
}
