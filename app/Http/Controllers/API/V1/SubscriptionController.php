<?php

namespace App\Http\Controllers\API\V1;

use Carbon\Carbon;
use App\Models\Language;
use App\Models\Transaction;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\UserSubscription;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\SubscriptionResource;

class SubscriptionController extends Controller
{
    //
    public function getSubscriptions(Request $request)
    {


        $user_id = Auth::user()->id;
        $language_code =  $request->header('language');
        $language = Language::where('code', $language_code)->where('status',1)->where('is_delete',0)->first();
        if (empty($language)) {
            return response()->json(
                [ 'status' => 0,'message' =>'Invalied Language Code'], 401
            );
        }
        try {
                $user_check_subscription = UserSubscription::where('user_id',$user_id ?? 0)->where('status','active')->first();
                if($user_check_subscription)
                {
                $arrayWithoutKeys = array_values([$user_check_subscription->subscription_id]);
                $scription_id_array[] = $user_check_subscription->subscription_id;
                $subscription = Subscription::where('is_delete', 0)->where('status',1)->whereNotIn('id',$arrayWithoutKeys)->get();
                $subscription_data = SubscriptionResource::collection($subscription);
                $current_subscription = Subscription::find($user_check_subscription->subscription_id);
                $current_subscription['expired_date'] = $user_check_subscription->end_date;
                $current_sub[] = new SubscriptionResource($current_subscription);
                }
                else
                {
                    $subscription = Subscription::where('is_delete', 0)->where('status',1)->get();
                    $subscription_data = SubscriptionResource::collection($subscription);
                    $current_sub[] = [];
                }
                return response()->json(
                    [
                        'data' => $current_sub,
                        'data1' => $subscription_data,
                        'status' => 1,
                        'message' => get_label("subscription_list_get_successfully",$language_code),
                    ], 200);

        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }

    }






    public function buyOrUpdateUserSubscription(Request $request)
    {


        $language_code =  $request->header('language');
        $language = Language::where('code', $language_code)->where('status',1)->where('is_delete',0)->first();
        if (empty($language)) {
            return response()->json(
                [ 'status' => 0,'message' =>'Invalied Language Code'], 401
            );
        }

        $validated = [];
        // $validated['user_id'] = "required";
        $user_id = Auth::user()->id;
        $device_type = Auth::user()->device_type;
        $fcm_token = Auth::user()->fcm_token;

        $validated['subscription_id'] = "required";
        $validated['payment_mode'] = "required";
        $validated['transaction_type'] = "required";

        $customMessages = [
            'subscription_id.required' => get_label("the_subscription_id_field_is_required",$language_code),
            'payment_mode.required' => get_label("the_payment_mode_field_is_required",$language_code),
            'transaction_type.required' => get_label("the_transaction_type_field_is_required",$language_code),
        ];

        $request->validate($validated, $customMessages);

        try{
            $user_subcription = UserSubscription::where("user_id",$user_id)->where("status","active")->first();
            if(!empty($user_subcription))
            {
                $user_subcription->status = "inactive";
                $user_subcription->update();
            }


            $subscription_info =  Subscription::find($request->subscription_id);
            if($subscription_info){
                        $plan_days = $subscription_info->duration;

                        $currentDate = Carbon::now();

                        // Add subscription duration days to the current date
                        $newDate = $currentDate->copy()->addDays($plan_days);

                        // Format the dates as "Y-m-d"
                        $start_Date = $currentDate->format('Y-m-d');
                        $end_Date = $newDate->format('Y-m-d');

                        $transaction_data = new Transaction();
                        $transaction_data->user_id = $user_id ?? 0;
                        $transaction_data->subscription_id = $request->subscription_id ?? 0;
                        $transaction_data->payment_mode = $request->payment_mode;
                        $transaction_data->transaction_type = $request->transaction_type;
                        $transaction_data->amount = $subscription_info->amount ?? 0;
                        $transaction_data->status = "success";
                        $transaction_data->save();

                        if($transaction_data)
                        {
                            $purchase_subscription = new UserSubscription();
                            $purchase_subscription->user_id = $user_id ?? 0;
                            $purchase_subscription->transaction_id = $transaction_data->id ?? 0;
                            $purchase_subscription->subscription_id = $request->subscription_id ?? 0;
                            $purchase_subscription->plan_duration = $subscription_info->duration ?? 0;
                            $purchase_subscription->start_date = $start_Date;
                            $purchase_subscription->end_date = $end_Date;
                            $transaction_data->active = "success";
                            $purchase_subscription->save();

                           $check_send_notification =  send_notifications($user_id,$fcm_token ?? 0,$device_type ?? "Android","Push_notification","update_subscripotion","update_subscripotion_succesfully");


                            return response()->json(
                                [
                                    'status' => 1,
                                    'message' =>  get_label("subscription_purchase_successfully",$language_code),

                                ], 200);

                        }
            }
            else
            {
                return response()->json(
                    [
                        'status' => 0,
                        'message' => get_label("subscription_not_found",$language_code),
                    ], 200);
            }

        }
        catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }

    }


}
