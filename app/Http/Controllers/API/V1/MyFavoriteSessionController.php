<?php

namespace App\Http\Controllers\API\V1;

use App\Models\User;
use App\Models\Language;
use App\Models\MyFavorite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\MyFavoriteSessionResource;

class MyFavoriteSessionController extends Controller
{
    //
    public function addOrRemoveFavorite(Request $request)
    {


        $language_code = $request->header('language');
        $language = Language::where('code', $language_code)->where('status', 1)->where('is_delete', 0)->first();
        if (empty($language)) {
            return response()->json(
                ['status' => 0, 'message' => 'Invalied Language Code'], 401
            );
        }

        $validated = [];
        $validated['session_id'] = "required";

        $customMessages = [
            'session_id.required' => get_label("the_session_id_field_is_required",$language_code),
        ];

       $request->validate($validated, $customMessages);

        try {

            $id = Auth::user()->id;
            $data = MyFavorite::where('user_id',$id)->where('session_id',$request->session_id)->first();
            if (empty($data)) {

               $favorite_data = new MyFavorite();
               $favorite_data->user_id = Auth::user()->id ?? 0;
               $favorite_data->session_id = $request->session_id ?? 0;
               $favorite_data->save();

               if($favorite_data) {
                return response()->json(
                    [
                        'status' => 1,
                        'message' =>  get_label("session_added_to_favorite_list",$language_code),
                    ], 200);
               }

            } else {


               $data1 = MyFavorite::where('user_id',$id)->where('session_id',$request->session_id)->delete();

                return response()->json(
                    [
                        'status' => 1,
                        'message' => get_label("session_remove_from_favorite_list",$language_code),
                    ], 200);

            }

        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }
    }




     //get user favorite my-session
     public function myFavoriteSession(Request $request)
     {

        $language_code = $request->header('language');
        $language = Language::where('code', $language_code)->where('status', 1)->where('is_delete', 0)->first();
        if (empty($language)) {
            return response()->json(
                ['status' => 0, 'message' => 'Invalied Language Code'], 401
            );
        }

        try{

                        $session = MyFavorite::with('MySession')->where("user_id",Auth::user()->id)->where('is_delete',0);
                        if (!empty($request->search)) {

                            $session->whereHas('MySession', function ($q) use ($request) {
                                $q->where('title', 'LIKE', '%' . $request->search . '%');
                            });

                        }

                        $total = $session->count();
                        $data = $session->paginate(10);
                        $data1 = MyFavoriteSessionResource::collection($data);
                            return response()->json([
                                'data' =>$data1,
                                'status' => '1',
                                'total' => $total,
                                'success' => get_label("my_session_get_successfully",$language_code),
                            ]);
                    }
                        catch (Exception $ex) {
                            return response()->json(
                                ['success' => 0, 'message' => $ex->getMessage()], 401
                            );
                        }
     }

}
