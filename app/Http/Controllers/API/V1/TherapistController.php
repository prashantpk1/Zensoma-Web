<?php

namespace App\Http\Controllers\API\V1;

use DateTime;
use DateTimeZone;
use Carbon\Carbon;
use App\Models\Slot;
use App\Models\User;
use App\Models\Booking;
use App\Models\Language;
use App\Models\Transaction;
use App\Models\Slot_Details;
use Illuminate\Http\Request;
use Jubaer\Zoom\Facades\Zoom;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\BookingResource;
use App\Http\Resources\MyBookingResource;

class TherapistController extends Controller
{
    //

    public function availableSlot(Request $request)
    {


        $language_code = $request->header('language');
        $language = Language::where('code', $language_code)->where('status', 1)->where('is_delete', 0)->first();
        if (empty($language)) {
            return response()->json(
                ['status' => 0, 'message' => 'Invalied Language Code'], 401
            );
        }

        $validated = [];
        $validated['date'] = "required";
        $validated['category_id'] = "required";
        $validated['therapist_id'] = "required";

        $customMessages = [
            'date.required' => get_label("the_date_field_is_required",$language_code),
            'category_id.required' => get_label("the_category_id_field_is_required",$language_code),
            'therapist_id.required' => get_label("the_therapist_id_field_is_required",$language_code),
        ];

        $request->validate($validated, $customMessages);

        $request->validate($validated);

        // Split the string into an array
        $dateArray = explode("-", $request->date);
        // Extract month and year from the array
        $month = $dateArray[0];
        $year = $dateArray[1];



        try {

            $data = Slot::with('slot_details1')->select('id', 'date', 'title', 'price_per_slot')->where('user_id', $request->therapist_id)->where('category_id', $request->category_id)->whereMonth('date', $month)->whereYear('date', $year)->get();

            // dd($data);
            if ($data) {
                return response()->json(
                    [
                        'data' => $data,
                        'status' => 1,
                        'message' => get_label("slot_list_get_successfully",$language_code),
                    ], 200);
            } else {
                return response()->json(
                    [
                        'data' => [],
                        'status' => 1,
                        'message' => get_label("slot_list_get_successfully",$language_code),
                    ], 200);
            }
        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }

    }

    public function booking(Request $request)
    {


        $language_code = $request->header('language');
        $language = Language::where('code', $language_code)->where('status', 1)->where('is_delete', 0)->first();
        if (empty($language)) {
            return response()->json(
                ['status' => 0, 'message' => 'Invalied Language Code'], 401
            );
        }


        $validated = [];
        $validated['slot_id'] = "required";
        $validated['payment_status'] = "required";

         $customMessages = [
            'slot_id.required' => get_label("the_slot_id_field_is_required",$language_code),
            'payment_status.required' => get_label("the_payment_status_field_is_required",$language_code),
        ];

        $request->validate($validated, $customMessages);

        try {


       $booking_check = Booking::where('slot_id',$request->slot_id)->first();

       if(empty($booking_check)) {

            $data = Slot_Details::with('slot_info')->find($request->slot_id);
            $transaction = new Transaction();
            $transaction->user_id = Auth::user()->id;
            $transaction->payment_mode = "direct_payment";
            $transaction->transaction_type = "booking";
            $transaction->amount = $data->slot_info->price_per_slot;
            $transaction->status = "success";
            $transaction->save();

            if (!empty($transaction)) {
                $booking_data = new Booking;
                $booking_data->transaction_id = $transaction->id;
                $booking_data->therapist_id = $data->slot_info->user_id;
                $booking_data->user_id = Auth::user()->id;
                $booking_data->date = $data->slot_info->date;
                $booking_data->start_time = $data->start_time;
                $booking_data->end_time = $data->end_time;
                $booking_data->slot_id = $data->id; //(slot_detail table id)
                $booking_data->status = $request->payment_status;
                $booking_data->is_delete = 0;
                $booking_data->save();

                if (!empty($booking_data)) {

                    $data->is_available = 1;
                    $data->is_available_update_at = date("Y-m-d H:i:s", Carbon::now()->timestamp);
                    $data->update();


                    $therapist_data = User::find($data->slot_info->user_id);
                    $customer_name = Auth::user()->name;

                    $time_zone = config('app.timezone');
                    $meeting_date = $data->slot_info->date."T".$data->start_time. ':00Z';


                    $meetings = Zoom::createMeeting([
                        "agenda" => @$therapist_data->name. " Meeting with " .@$customer_name,
                        "topic" => @$therapist_data->name. " Meeting with " .@$customer_name,
                        "type" => 2, // 1 => instant, 2 => scheduled, 3 => recurring with no fixed time, 8 => recurring with fixed time
                        "duration" => $data->duration, // in minutes
                        "timezone" => 'Asia/Kolkata', // set your timezone
                        "password" => '12345678',
                        "start_time" => $meeting_date, // set your start time
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

                    if(!empty($meetings))
                    {
                        $booking_data->meeting_id = $meetings['data']['id'];
                        $booking_data->meeting_password = $meetings['data']['password'];
                        $booking_data->meeting_response = $meetings['data'];
                        $booking_data->update();
                    }


                    $result = new BookingResource($booking_data);

                    if ($data) {
                        return response()->json(
                            [
                                'data' => $result,
                                'status' => 1,
                                'message' => get_label("slot_booking_successfully",$language_code),
                            ], 200);
                    } else {
                        return response()->json(
                            [
                                'data' => [],
                                'status' => 0,
                                'message' => get_label("oops_something_went_wrong",$language_code),
                            ], 200);
                    }

                } else {
                    return response()->json(
                        [
                            'data' => [],
                            'status' => 0,
                            'message' => get_label("oops_something_went_wrong",$language_code),
                        ], 200);
                }

            } else {
                return response()->json(
                    [
                        'data' => [],
                        'status' => 0,
                        'message' => get_label("oops_something_went_wrong",$language_code),
                    ], 200);
            }

        } else {
            return response()->json(
                [
                    'data' => [],
                    'status' => 0,
                    'message' =>  get_label("This_slot_is_already_book",$language_code),
                ], 200);
        }





        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }

    }

    public function mybooking(Request $request)
    {

        $language_code = $request->header('language');
        $language = Language::where('code', $language_code)->where('status', 1)->where('is_delete', 0)->first();
        if (empty($language)) {
            return response()->json(
                ['status' => 0, 'message' => 'Invalied Language Code'], 401
            );
        }

        try {

            $booking = Booking::with('therapist_data','Slot_Details')->where('user_id', Auth::user()->id)->where('is_delete', 0);
            $currentDateTime = Carbon::now()->format('Y-m-d');


            if($request->type == "0")
            {
                $booking->where('date', '>=',$currentDateTime);
            }
            else
            {
                $booking->where('date', '<', $currentDateTime);
            }

            if (!empty($request->search)) {

                $booking->whereHas('therapist_data', function ($q) use ($request) {
                    $q->where('name', 'LIKE', '%' . $request->search . '%');
                });

            }

            $total = $booking->count();
            $data = $booking->paginate(10);
            // $result =   new MyBookingResource($data);

            $result = MyBookingResource::collection($data);

            if ($result) {
                return response()->json(
                    [
                        'data' => $result,
                        'status' => 1,
                        'message' => get_label("slot_booking_successfully",$language_code),
                    ], 200);
            } else {
                return response()->json(
                    [
                        'data' => [],
                        'status' => 0,
                        'message' => get_label("oops_something_went_wrong",$language_code),
                    ], 200);
            }
        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }

    }

}
