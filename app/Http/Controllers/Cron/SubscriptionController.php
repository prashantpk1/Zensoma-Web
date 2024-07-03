<?php

namespace App\Http\Controllers\Cron;

use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Http\Request;
use App\Models\UserSubscription;
use App\Http\Controllers\Controller;

class SubscriptionController extends Controller
{
    //

    public function subscriptionExpired()
    {
        $currentDate =  date("Y-m-d");
         $data = UserSubscription::with('user_data')->where('status',"active")->where('end_date', '<', $currentDate)->get();
         foreach($data  as  $subscription_detail)
         {
                 $subscription_update = UserSubscription::find($subscription_detail->id);
                 $subscription_update->status = "expired";
                 $subscription_update->update();

                 $token = "";
                 $token = $subscription_detail->user_data->fcm_token ?? "";
                 $device_type = $subscription_detail->user_data->device_type ?? "Android";
                 $notification_type = "subscription_expired";
                 $noti_title = "subscription_expired";
                 $notification_message = "subscription_expired";
                 
             
                     if ($token != "") {
                         send_notifications($subscription_detail->user_id, $token, $device_type, $notification_type, $noti_title, $notification_message);
                     }
     
         }
         
    }

    public function  addEntryUserDetail()
    {
            $users = User::get();
            foreach($users as $user)
            {

           $check_user = UserDetails::where("user_id",$user->id)->first();
           if(empty($check_user)) {

                $user_detail = UserDetails::create([
                    'user_id' => $user->id ?? 0,
                    'total_refer_count' => 0,
                    'total_challenge_complate_count' => 0,
                    'total_minute_spend' => 0,
                    'current_level_id' => 1,
                    'badge_ids' => [],
                ]);

           }

            }
    }
    
}
