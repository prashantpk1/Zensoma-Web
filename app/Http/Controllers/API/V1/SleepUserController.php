<?php

namespace App\Http\Controllers\API\V1;

use DateTime;
use App\Models\Language;
use Illuminate\Http\Request;
use App\Models\UserSleepDetail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SleepUserController extends Controller
{
    //
    public function userSleepLogSave(Request $request)
    {

        $language_code = $request->header('language');
        $language = Language::where('code', $language_code)->where('status', 1)->where('is_delete', 0)->first();
        if (empty($language)) {
            return response()->json(
                ['status' => 0, 'message' => 'Invalied Language Code'], 401
            );
        }
        $validated = [];
        $validated['sleep_start_date'] = "required";
        $validated['sleep_end_date'] = "required";
        $validated['sleep_start_time'] = "required";
        $validated['sleep_end_time'] = "required";

        $customMessages = [
            'sleep_start_date.required' => "Sleep start date is required.",
            'sleep_end_date.required' => "Sleep end date is required.",
            'sleep_start_time.required' => "Sleep start time is required.",
            'sleep_end_time.required' => "Sleep end time is required.",
        ];

       $request->validate($validated, $customMessages);
       try {

                    $data = new UserSleepDetail();
                    $data->user_id = Auth::user()->id ?? 0;
                    $data->sleep_start_date = $request->sleep_start_date;
                    $data->sleep_end_date = $request->sleep_end_date;
                    $data->sleep_start_time = $request->sleep_start_time;
                    $data->sleep_end_time = $request->sleep_end_time;

                    // Create DateTime objects for start and end times
                    $startTime = new DateTime($request->sleep_start_time);
                    $endTime = new DateTime($request->sleep_end_time);

                    // Calculate the duration
                    $interval = $startTime->diff($endTime);

                    // Format the duration as "H:i" (hours:minutes)
                    $duration = $interval->format('%H:%I');

                    // Store the duration
                    $data->duration = $duration;
                    $data->sleep_log = $duration;

                    $data->save();

                    if($data) {
                        return response()->json(
                            [
                                'data' => $data,
                                'status' => 1,
                                'message' =>  "Data Saved Succefully.",
                            ], 200);
                    }


        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }



    }
}
