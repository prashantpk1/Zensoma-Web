<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use Jubaer\Zoom\Facades\Zoom;
use App\Http\Controllers\Controller;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class ZoomController extends Controller
{

   public function create()
   {

    $meetings = Zoom::createMeeting([
        "agenda" => 'your agenda',
        "topic" => 'your topic',
        "type" => 2, // 1 => instant, 2 => scheduled, 3 => recurring with no fixed time, 8 => recurring with fixed time
        "duration" => 60, // in minutes
        "timezone" => 'Asia/Kolkata', // set your timezone
        "password" => '12345678',
        "start_time" => date('Y-m-dTh:i:00') . 'Z', // set your start time
        // "template_id" => 'set your template id', // set your template id  Ex: "Dv4YdINdTk+Z5RToadh5ug==" from https://marketplace.zoom.us/docs/api-reference/zoom-api/meetings/meetingtemplates
        // "pre_schedule" => false,  // set true if you want to create a pre-scheduled meeting
        // "schedule_for" => 'set your schedule for profile email ', // set your schedule for
        "settings" => [
            'join_before_host' => false, // if you want to join before host set true otherwise set false
            'host_video' => false, // if you want to start video when host join set true otherwise set false
            'participant_video' => false, // if you want to start video when participants join set true otherwise set false
            'mute_upon_entry' => false, // if you want to mute participants when they join the meeting set true otherwise set false
            'waiting_room' => false, // if you want to use waiting room for participants set true otherwise set false
            'audio' => 'both', // values are 'both', 'telephony', 'voip'. default is both.
            'auto_recording' => 'none', // values are 'none', 'local', 'cloud'. default is none.
            'approval_type' => 0, // 0 => Automatically Approve, 1 => Manually Approve, 2 => No Registration Required
        ],

    ]);



                dd($meetings);
   }



   public function join_meeting()
    {
        // $user = Auth::user();
        // $schedule_class = IsScheduletimis::where('meeting_id', )->first();

        $api_key = "UtCjrDBRZyjJE6RjKkFmQ";
        $api_secret = "ckc927nlOxqEfmEt6a1PTr2aav8Ho6Ic";

        $meetingNumber = "95114602805";
        $passWord = "12345678";
        $userName = "bhai jan";
        $role = "1";
        // if ($user->users_types == 4) { //teacher
        //     if (empty($user->teacher_name)) {
        //         $userName = $user->first_name . ' ' . $user->last_name;
        //     } else {
        //     }
        // } elseif ($user->users_types == 6) { //student
        //     if (empty($user->student_name)) {
        //         $userName = $user->first_name . ' ' . $user->last_name;
        //     } else {
        //         $userName = $user->student_name;
        //     }
        //     $role = "0";
        // } else {
        //     $userName = "error";
        //     $role = "2";
        // }
        $url = url()->previous();
        return view('join_meeting', compact('api_key', 'api_secret', 'meetingNumber', 'passWord', 'userName', 'role', 'url'));
    }


    public function generateToken(Request $request)
    {
        $key = env('ZOOM_SDK_KEY');
        $secret = env('ZOOM_SDK_SECRET');
        $meetingNumber = 1;
        $role = 1; // 0 for participant, 1 for host
        $userName = "admin";
        $userId = 1; // optional
        $userEmail = "ketandabhi0909@gmail.com"; // optional

        $payload = [
            'sdkKey' => $key,
            'mn' => $meetingNumber,
            'role' => $role,
            'iat' => time(),
            'exp' => time() + 3600, // Token valid for 1 hour
            'appKey' => $key,
            'tokenExp' => time() + 3600
        ];

        $jwt = JWT::encode($payload, $secret, 'HS256');

        return response()->json([
            'signature' => $jwt,
            'userName' => $userName,
            'meetingNumber' => $meetingNumber,
            'role' => $role,
            'userId' => $userId,
            'userEmail' => $userEmail,
        ]);
    }


}
