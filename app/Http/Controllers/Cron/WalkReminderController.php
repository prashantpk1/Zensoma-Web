<?php

namespace App\Http\Controllers\Cron;

use Illuminate\Http\Request;
use App\Models\WalkReminder;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class WalkReminderController extends Controller
{
    //

    public function sendWalkRemindersDayAt()
    {
        $data = WalkReminder::with('user_detail')->get();
        foreach ($data as $reminder) {

            //  check reminder switch
            if($reminder->reminder_switch == 0) {
            
                    $token = "";
                    $token = $reminder->user_detail->fcm_token ?? "";
                    $device_type = $reminder->user_detail->device_type ?? "Android";
                    $notification_type = "walk_reminder";
                    $noti_title = "walk_reminder";
                    $notification_message = "walk_reminder";
                    $device_type = $reminder->user_detail->device_type ?? "";

                    $time = (date('G'));

                    $timeWithoutSeconds = substr($reminder->reminder_me_every_day_at, 0, 5); // Extract the first 5 characters (HH:MM)
                    // $currentTime = "10:00";
                    $currentTime = date('H:i');
                    if ($timeWithoutSeconds == $currentTime) {
                        if ($token != "") {
                            send_notifications($reminder->user_id, $token, $device_type, $notification_type, $noti_title, $notification_message);
                        }

                    }
            }

        }
    }


    public function WalkReminderSave(Request $request)
    {

        $validated = [];
        $validated['reminder_me_every_day_at'] = "required";
        $validated['reminder_switch'] = "required";
        $request->validate($validated);
        try {

            $user_id = Auth::user()->id;
            $data = WalkReminder::where("user_id",$user_id)->first();
            if(empty($data)){
            $data = new WalkReminder();
            }
            $data->reminder_me_every_day_at = $request->reminder_me_every_day_at;
            $data->reminder_switch = $request->reminder_switch;
            $data->user_id = $user_id;
            $data->save();

            if ($data) {
                return response()->json(
                    [
                        'status' => 1,
                        'message' => "Date Update Succesfully",
                    ], 200);
            }

        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }

    }

}
