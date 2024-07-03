<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Language;
use App\Models\Referals;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\FriendResource;

class FrinedListsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function addFriend(Request $request)
    {
        $language_code = $request->header('language');
        $language = Language::where('code', $language_code)->where('status', 1)->where('is_delete', 0)->first();
        if (empty($language)) {
            return response()->json(
                ['status' => 0, 'message' => 'Invalied Language Code'], 401
            );
        }


        $validated = [];
        // $validated['sender_id'] = "required";
        $validated['received_id'] = "required";

        $customMessages = [
            'received_id.required' => get_label("the_received_id_field_is_required",$language_code),
        ];

       $request->validate($validated, $customMessages);

        $sender_id = Auth::user()->id;
        try {

            $data = Referals::where('sender_id',$sender_id)->where('received_id',$request->received_id)->first();
            if (empty($data)) {

               $referral_data = new Referals();
               $referral_data->sender_id = $sender_id;
               $referral_data->received_id = $request->received_id;
               $referral_data->save();

               if($referral_data) {
                return response()->json(
                    [
                        'status' => 1,
                        'message' => get_label("friend_added_to_friend_list",$language_code),
                    ], 200);
               }

            }
            else
            {
                return response()->json(
                    [
                        'status' => 1,
                        'message' => get_label("friend_already_added_to_friend_list",$language_code),
                    ], 200);
            }

        }
        catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }




    }


     /**
     * Display a listing of the resource.
     */
    public function removeFriend(Request $request)
    {
        //


        $validated = [];
        // $validated['sender_id'] = "required";
        $sender_id = Auth::user()->id;
        $validated['received_id'] = "required";
        $request->validate($validated);
        try {

            $data = Referals::where('sender_id',$sender_id)->where('received_id',$request->received_id)->delete();
            if($data)
            {
                   return response()->json(
                        [
                            'status' => 1,
                            'message' => "Friend Remove From Friend List",
                        ], 200);
            }
            else
            {
                  return response()->json(
                    [
                        'status' => 1,
                        'message' => "Friend Not Added To Friend List",
                    ], 200);
            }


        }
        catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }


    }


     /**
     * Display a listing of the resource.
     */
    public function friendList()
    {
        //
        $id = Auth::user()->id;
        $data = Referals::with('received_user_data')->where("sender_id",$id)->paginate(10);
        $user_data = FriendResource::collection($data);
            return response()->json(
                [
                    'data' => $user_data,
                    'status' => 1,
                    'message' => "Friend List",
                ], 200);


    }



}
