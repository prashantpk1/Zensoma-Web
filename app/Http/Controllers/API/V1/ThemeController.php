<?php

namespace App\Http\Controllers\API\V1;

use App\Models\User;
use App\Models\Theme;
use App\Models\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ThemeResource;

class ThemeController extends Controller
{
    //
    public function getThemes(Request $request)
    {

        $language_code = $request->header('language');
        $language = Language::where('code', $language_code)->where('status', 1)->where('is_delete', 0)->first();
        if (empty($language)) {
            return response()->json(
                ['status' => 0, 'message' => 'Invalied Language Code'], 401
            );
        }
        try {
             $data = Theme::where('status',1)->where('is_delete',0)->get();
             $data_new = ThemeResource::collection($data);
               if($data_new) {
                return response()->json(
                    [
                        'data' => $data_new,
                        'status' => 1,
                        'message' => get_label("theme_list_get_successfully",$language_code),
                    ], 200);
               }else
               {
                return response()->json(
                    [
                        'status' => 0,
                        'message' => get_label("theme_list_get_successfully",$language_code),
                    ], 200);
               }



        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }


    }

    public function themeSave(Request $request)
    {
        $language_code = $request->header('language');
        $language = Language::where('code', $language_code)->where('status', 1)->where('is_delete', 0)->first();
        if (empty($language)) {
            return response()->json(
                ['status' => 0, 'message' => 'Invalied Language Code'], 401
            );
        }

        $validated = [];
        $validated['theme_id'] = "required";

        $customMessages = [
            'theme_id.required' => get_label("the_theme_id_field_is_required",$language_code),
        ];

        $request->validate($validated, $customMessages);
                try {
                           $data = Auth::user();
                        //    $data = User::find($id);
                           $data->theme_id = $request->theme_id;
                           $data->update();

                           if($data) {
                            return response()->json(
                                [
                                    'status' => 1,
                                    'message' => get_label("theme_change_successfully",$language_code),
                                ], 200);
                           }


                    } catch (Exception $ex) {
                        return response()->json(
                            ['success' => 0, 'message' => $ex->getMessage()], 401
                        );
                    }
    }

}
