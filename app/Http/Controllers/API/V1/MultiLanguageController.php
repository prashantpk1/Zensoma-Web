<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Language;
use Illuminate\Http\Request;
use App\Models\MultiLanguage;
use App\Http\Controllers\Controller;
use App\Http\Resources\MultiLanguageResource;

class MultiLanguageController extends Controller
{
    //
    public function getAllLabels(Request $request)
    {
        $language_name = $request->header('language');
        $language = Language::where('code', $language_name)->where('status',1)->where('is_delete',0)->first();
        if (empty($language)) {
            return response()->json(
                [ 'status' => 0,'message' =>'Invalied Language Code'], 401
            );
        }
            try {
                $data = MultiLanguage::where('is_delete', 0)->get();

                foreach ($data as $item) {
                    // Extract key from item
                    $key = $item['key'];

                    // Create an object with the key name
                    ${$key} = (object)$item;

                    // Example:
                    $content_array = json_decode($item->content);

                    $content_lang  = $content_array->$language_name->content ?? "";
                    $data1[$key]  = $content_lang ?? "";

                }
               // $data = MultiLanguageResource::collection($data);
                return response()->json(
                    [
                        'data' => $data1,
                        'status' => 1,
                        'message' => get_label("app_label_and_title_get_successfully",$language_name),
                    ], 200);
            } catch (Exception $ex) {
                return response()->json(
                    ['success' => 0, 'message' => $ex->getMessage()], 401
                );
            }

    }
}
