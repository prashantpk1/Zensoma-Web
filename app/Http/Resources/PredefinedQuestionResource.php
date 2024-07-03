<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\OptionResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PredefinedQuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $language =  $request->header('language') ?? "en";
        $question_array = json_decode($this->question);
        $description_array = json_decode($this->descriptions);
        $question =  $question_array->$language->question;
        $description =  $description_array->$language->description;


        if($this->option_type == "range")
        {
            $option['range'] =  $this->options;
            $numberArray = explode('-',$this->options);
            $option['start_point'] =   $numberArray[0] ?? 0;
            $option['end_point'] =   $numberArray[1] ?? 0;

        }
        else
        {

            // $option_array = json_decode($this->options);
            // $option_arr =  $option_array->$language;


            // $newOptions = [];
            // foreach ($option_arr as $key => $value) {
            //     $newKey = str_replace('option', '', $key);
            //     $newOptions[$newKey] = $value;
            // }

            // $option = ["options" => $newOptions];
            $option = OptionResource::collection($this->option);

        }


           return [
            'id' => $this->id,
            'description' => $description,
            'question' => $question,
            'option_type' => $this->option_type,
            // 'options' => $option ?? "",
            'options' => $option ?? "",
        ];

    }
}
