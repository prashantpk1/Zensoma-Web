<?php

namespace App\Http\Resources;

use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Resources\Json\JsonResource;

class MyFavoriteSessionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $language =  $request->header('language');
        $title_name = json_decode($this->MySession->title);
        $title =  $title_name->$language->title;

        //get  category name
       $category_array =  json_decode($this->MySession->category_id);
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

        return [
            'session_id' => $this->MySession->id ?? "",
            'file' => URL::to('/public') . '/file/' .$this->MySession->file,
            'thumbnail_image' => URL::to('/public') . '/thumbnail_image/' .$this->MySession->thumbnail,
            'title' => $title ?? "",
            'category_name' => $category_name ?? "",
            'session_id' => $this->MySession->id ?? "",
            'creater_id' => $this->MySession->creater_id ?? "",
            'creater_name' => $this->MySession->creater_name ?? "",
            'creater_type' => $this->MySession->creater_type ?? "",
            'created_at' =>  date('Y-M-d h:i A', strtotime($this->MySession->created_at)),
            'updated_at' => date('Y-M-d h:i A', strtotime($this->MySession->updated_at)),
        ];
        $category_id = "";
        $category_name = "";
        $category = "";
    }
}
