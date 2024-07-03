<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CMSController extends Controller
{
    //
    public  function getCms(Request $request)
    {
        $languege_new =  $request->header('language');
        $language = Language::where('code', $languege_new)->where('status',1)->where('is_delete',0)->first();
        if (empty($language)) {
            return response()->json(
                [ 'status' => 0,'message' =>'Invalied Language Code'], 401
            );
        }


        $validated = [];
        $validated['page_name'] = "required";

        $customMessages = [
            'page_name.required' => get_label("the_page_name_field_is_required",$languege_new),
        ];

        $request->validate($validated, $customMessages);


        $url = env('APP_URL');
        $url_final['url'] = $url."get-cms-content/".$request->page_name."-".$languege_new;
        if (!empty($url_final)) {
            return response()->json(
                [
                    'data' =>$url_final,
                    'status' => 1,
                    'message' =>  get_label("url_found_successfully",$languege_new),
                ], 200);
        } else {
            return response()->json(
                [
                    'status' => 0,
                    'message' => get_label("somthing_went_wrong",$languege_new),
                ], 200);

        }

    }
}
