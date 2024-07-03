<?php

namespace App\Http\Controllers\API\V1;

use App\Models\User;
use App\Models\Words;
use App\Models\Wallet;
use App\Models\Language;
use App\Models\UserDetails;
use Illuminate\Http\Request;
use App\Models\ChallengeFriend;
use App\Models\UserSubscription;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ChallengeFrinedResource;

class ChallengeFriendController extends Controller
{
    //

    public  function addChallengeFriend(Request $request)
    {

        // $data = send_notifications(1,"f4Sa13QxD0E0oQUjpRsQPR:APA91bGz_jkQVAP8MGIMle6FqFMUhTBoShneIfVHlg07JRLou0OSDsk0zxMsLg6ByV2cUtAyta2W3fBc99t-KAZLWzvfSR1962LN1lr-4uVXoORULTnMLyAbZS5ulwQZyPkVCgviC9-c","Android","new_challenge","new_challenge","new_challenge");

        $language_code = $request->header('language');
        $language = Language::where('code', $language_code)->where('status', 1)->where('is_delete', 0)->first();
        if (empty($language)) {
            return response()->json(
                ['status' => 0, 'message' => 'Invalied Language Code'], 401
            );
        }

        $validated = [];
        $validated['session_id'] = "required";
        $validated['user_ids'] = "required";

        $customMessages = [
            'session_id.required' => get_label("the_session_id_field_is_required",$language_code),
            'user_ids.required' => get_label("the_user_id_field_is_required",$language_code),
        ];

       $request->validate($validated, $customMessages);
        try {

            // $user = json_decode($request->user_ids);

            $user = array_map('intval', $request->user_ids);


            foreach($user  as $user_data)
            {

                $user_detail = User::find($user_data);
                if($user_detail)
                {

                   $check_challenge = ChallengeFriend::where("session_id",$request->session_id)->where('challenge_from',Auth::user()->id)->where("challenge_to",$user_detail->id)->first();
                    // if(empty($check_challenge))
                    // {
                       
                        $data = new ChallengeFriend();
                        $data->session_id  = $request->session_id;
                        $data->challenge_from = Auth::user()->id;
                        $data->challenge_to = $user_detail->id;
                        $data->status = "pending";
                        $data->save();

                        $check_send_notification =  send_notifications($user_detail->id,$user_detail->fcm_token ?? 0,$user_detail->device_type ?? "Android","new_challenge","new_challenge","new_challenge");
                    // }
                }
            }
            return response()->json(
                [
                    'status' => 1,
                    'message' => get_label("challenge_send_successfully",$language_code),

                ], 200);



        }
        catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }



    }



    public function myChallenges(Request $request)
    {


        $language_code = $request->header('language');
        $language = Language::where('code', $language_code)->where('status', 1)->where('is_delete', 0)->first();
        if (empty($language)) {
            return response()->json(
                ['status' => 0, 'message' => 'Invalied Language Code'], 401
            );
        }

        $validated = [];
        $validated['type'] = "required";

        $customMessages = [
            'type.required' => get_label("the_type_field_is_required",$language_code),
        ];
        

       $request->validate($validated, $customMessages);
        try{

            $challengefrined = ChallengeFriend::with('session_data','user_challenge_from','user_challenge_to');

            if($request->type  == 0)
            {
                $challengefrined->where("challenge_from",Auth::user()->id);
            }
            else
            {
                $challengefrined->where("challenge_to",Auth::user()->id);
            }


            //search
            if (!empty($request->search)) {
                        $challengefrined->whereHas('session_data', function ($q) use ($request) {
                                $q->where('title', 'LIKE', '%' . $request->search . '%');
                            });
            }

            $total = $challengefrined->count();
            $data = $challengefrined->paginate(10);
            

            $user_check_subscription = UserSubscription::with('subscription')->where('user_id',Auth::user()->id ?? 0)->where('status','active')->first();
            // add key for aavailble from subscription
            foreach($data as $data_record)
            {
                if($user_check_subscription)
                {
                    $subscription_category = $user_check_subscription->subscription->category_id;

                                    if($user_check_subscription->subscription->subscription_type == "whole_system")
                                    {
                                         $data_record->is_available = 1;
                                    
                                    } else
                                    {
                                        
                                        $category_id = $data_record->session_data->category_id;
                                        $session_category = json_decode($category_id);
                                        $common_values = array_intersect($subscription_category, $session_category);
                                        if (!empty($common_values)) {
                                            $data_record->is_available = 1;
                                        } else {
                                            $data_record->is_available = 0;
                                        }
                                                    
                                    }



                }else
                {
                    $data_record->is_available = 0;
                }

            }

            $result = ChallengeFrinedResource::collection($data);

            return response()->json(
                [
                    'data' => $result,
                    'status' => 1,
                    'total' => $total,
                    'message' => get_label("my_challenge_get_successfully",$language_code),

                ], 200);

        }catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }

    }





    public function complateChallenge(Request $request)
    {


        $language_code = $request->header('language');
        $language = Language::where('code', $language_code)->where('status', 1)->where('is_delete', 0)->first();
        if (empty($language)) {
            return response()->json(
                ['status' => 0, 'message' => 'Invalied Language Code'], 401
            );
        }

        $validated = [];
        $validated['challenge_id'] = "required";

        $customMessages = [
            'challenge_id.required' => get_label("the_challenge_id_field_is_required",$language_code),
        ];

        $request->validate($validated, $customMessages);

        try{

            $data = ChallengeFriend::find($request->challenge_id);

            if($data->status == "pending") {

                    $data->status = "complate";
                    $data->update();

                    $amount  =  get_point_amount("challage_complate_to_earn");
                    if($amount >= 0) {
                                    $user_wallet = new Wallet();
                                    $user_wallet->user_id  = $data->challenge_to;
                                    $user_wallet->type = "credit";
                                    $user_wallet->amount = $amount;
                                    $user_wallet->save();
                    }

                    $user_detail = UserDetails::where('user_id',$data->challenge_to)->first();
                    if($user_detail) {
                    $user_detail->total_challenge_complate_count =  $user_detail->total_challenge_complate_count + 1;
                    $user_detail->update();
                    }



            }else
            {

                $data->status = "complate";
                $data->update();

            }



            return response()->json(
                [
                    'status' => 1,
                    'message' => get_label("challenge_completed_successfully",$language_code),

                ], 200);

        }
        catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }
    }






}
