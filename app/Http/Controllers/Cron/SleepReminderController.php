<?php

namespace App\Http\Controllers\Cron;

use App\Http\Controllers\Controller;
use App\Models\SleepReminder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SleepReminderController extends Controller
{
    //

    public function sleepReminderStartAtAndEndAt(Request $request)
    {
        $data = SleepReminder::with('user_detail')->get();
        foreach ($data as $reminder) {

            $token = "";
            $token = $reminder->user_detail->fcm_token ?? "";
            $device_type = $reminder->user_detail->device_type ?? "Android";
            $notification_type = "sleep_reminder";
            $noti_title_start = "time_to_sleep_reminder";
            $noti_title_end = "time_to_end_sleep_reminder";
            $notification_message_start = "time_to_sleep_reminder";
            $notification_message_end = "time_to_end_sleep_reminder";
            $device_type = $reminder->user_detail->device_type ?? "";

            $time = (date('G'));

            $start_at = substr($reminder->start_time, 0, 5); // Extract the first 5 characters (HH:MM)
            $end_at = substr($reminder->end_time, 0, 5); // Extract the first 5 characters (HH:MM)

            // $currentTime = "10:00";
            $currentTime = date('H:i');
            if ($reminder->start_time_switch == 0) {
                if ($start_at == $currentTime) {
                    if ($token != "") {
                        send_notifications($reminder->user_id, $token, $device_type, $notification_type, $noti_title_start, $notification_message_start);
                    }

                }
            }

            if ($reminder->end_time_switch == 0) {
                if ($end_at == $currentTime) {
                    if ($token != "") {
                        send_notifications($reminder->user_id, $token, $device_type, $notification_type, $noti_title_end, $notification_message_end);
                    }

                }
            }

        }
    }

    public function SleepReminderSave(Request $request)
    {

        $validated = [];
        $validated['start_time'] = "required";
        $validated['end_time'] = "required";
        $validated['start_time_switch'] = "required";
        $validated['end_time_switch'] = "required";
        $request->validate($validated);
        try {

            $user_id = Auth::user()->id;
            $data = SleepReminder::where("user_id", $user_id)->first();
            if (empty($data)) {
                $data = new SleepReminder();
            }
            $data->start_time_switch = $request->start_time_switch;
            $data->start_time = $request->start_time;
            $data->end_time_switch = $request->end_time_switch;
            $data->end_time = $request->end_time;
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
