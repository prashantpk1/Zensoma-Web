<?php

namespace App\Http\Controllers\Cron;

use App\Http\Controllers\Controller;
use App\Models\DrinkWaterReminder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DrinkWaterReminderController extends Controller
{
    //

    public function sendWaterReminders()
    {

        $data = DrinkWaterReminder::where('reminder_type', 1)->with('user_detail')->get();
        foreach ($data as $reminder) {

            //    check reminder switch
            if ($reminder->reminder_switch == 0) {
                $token = "";
                $token = $reminder->user_detail->fcm_token ?? "";
                $device_type = $reminder->user_detail->device_type ?? "Android";
                $notification_type = "drink_water_reminder";
                $noti_title = "drink_water_reminder";
                $notification_message = "drink_water_reminder";
                $device_type = $reminder->user_detail->device_type ?? "";

                $time = (date('G'));

                if (in_array($time, $reminder->remind_me_every_hour)) {

                    if ($token != "") {
                        send_notifications($reminder->user_id, $token, $device_type, $notification_type, $noti_title, $notification_message);
                    }

                }

            }

        }
    }

    public function sendWaterRemindersDayAt()
    {
        $data = DrinkWaterReminder::where('reminder_type', 2)->with('user_detail')->get();
        foreach ($data as $reminder) {

            //    check reminder switch
            if ($reminder->reminder_switch == 0) {

                $token = "";
                $token = $reminder->user_detail->fcm_token ?? "";
                $device_type = $reminder->user_detail->device_type ?? "Android";
                $notification_type = "drink_water_reminder";
                $noti_title = "drink_water_reminder";
                $notification_message = "drink_water_reminder";
                $device_type = $reminder->user_detail->device_type ?? "";

                $time = (date('G'));

                $timeWithoutSeconds = substr($reminder->reminder_me_every_day_at, 0, 5); // Extract the first 5 characters (HH:MM)
                $currentTime = date('H:i');
                if ($timeWithoutSeconds == $currentTime) {

                    if ($token != "") {
                        send_notifications($reminder->user_id, $token, $device_type, $notification_type, $noti_title, $notification_message);
                    }

                }
            }

        }
    }

    public function drinkWaterReminderSave(Request $request)
    {
        $validated = [];
        $validated['reminder_start_time'] = "required";
        $validated['reminder_end_time'] = "required";
        $validated['reminder_type'] = "required";
        $validated['remind_me_every_hour'] = "required";
        $validated['reminder_me_every_day_at'] = "required";
        $validated['reminder_switch'] = "required";
        $request->validate($validated);
        try {

            $number = $request->remind_me_every_hour;

            $start_point = substr($request->reminder_start_time, 0, 2);
            $end_point = substr($request->reminder_end_time, 0, 2);

            $multiples = [];

            if ($request->reminder_type == 1) {

                // for ($i = $number; $i <= 24; $i += $number) {
                //     $multiples[] = "$i";
                // }

                for ($i = $start_point; $i <= $end_point; $i += $number) {
                    $multiples[] = "$i";
                }

            }

            $user_id = Auth::user()->id;

            $data = DrinkWaterReminder::where("user_id", $user_id)->first();
            if (empty($data)) {
                $data = new DrinkWaterReminder();
            }

            $data->reminder_start_time = $request->reminder_start_time;
            $data->reminder_end_time = $request->reminder_end_time;

            $data->reminder_type = $request->reminder_type;
            $data->remind_me_every_hour_number = $number ?? 0;

            if ($request->reminder_type == 1) {

                $data->remind_me_every_hour = $multiples;
            }
            if ($request->reminder_type == 2) {

                $data->reminder_me_every_day_at = $request->reminder_me_every_day_at;
            }

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
