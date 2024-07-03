<?php

namespace App\Http\Controllers\SubAdmin;

use App\Http\Controllers\Controller;
use App\Models\Slot;
use App\Models\Slot_Details;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dateTime = new DateTime(Carbon::now());
        $formattedDate = $dateTime->format('Y-m-d');
        $user = Auth::user();
        $data = Slot::where("user_id", $user->id)->where("created_at", ">", $formattedDate)->with('slot_details')->get();

        return view('SubAdmin.Calendar.index', compact('data', 'formattedDate'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        //
        $validated = [];
        $validated['date'] = "required";
        $validated['start_time'] = "required";
        $validated['end_time'] = "required";
        $validated['slot_duration'] = "required|numeric";
        $validated['category_id'] = "required";
        $validated['title'] = "required";
        $validated['price'] = "required|min:1|numeric";
        $request->validate($validated);

        $dateTime = new DateTime(Carbon::now());
        $current_date = $dateTime->format('Y-m-d');

        try {
            $start_time = $request->start_time;
            $end_time = $request->end_time;
            $duration = $request->slot_duration;
            $title = $request->title;
            $category_id = $request->category_id;
            $price = $request->price;
            $dateArray = explode(", ", $request->date);

            $date_array = array_map(function ($date) {
                return $date;
            }, $dateArray);

            $datecount = count($dateArray);

            $startTime = $request->start_time;
            $endTime = $request->end_time;

            $interval = $duration * 60; // duration in seconds

            $startTimestamp = strtotime($startTime);
            $endTimestamp = strtotime($endTime);

            // Initialize an array to store time slots
            $timeSlots = array();

            // Create time slots with 30-minute gaps
            while ($startTimestamp < $endTimestamp) {
                $endTimestampSlot = $startTimestamp + $interval;

                $timeSlots[] = array(
                    'start' => date('H:i', $startTimestamp),
                    'end' => date('H:i', $endTimestampSlot),
                );

                $startTimestamp = $endTimestampSlot;
            }

            $user = Auth::user()->id;

            //price calculation start
            $price_count =  count($timeSlots);
            if($request->price_type == "price_per_slot")
            {
                $price = $request->price;
            }
            else
            {
                $price = ($request->price/$price_count);
            }

            //price calculation end

            foreach ($date_array as $key => $date) {

                if ($date >= $current_date) {
                $slot_check = Slot::where('user_id',$user)->where('date',$date)->first();
                if(empty($slot_check)) {
                    $data = new Slot();
                    $data->user_id = $user;
                    $data->date = $date;
                    $data->title = $title;
                    $data->category_id = $category_id;
                    $data->price_per_slot = $price;
                    $data->is_draft = 0;
                    $data->status = 1;
                    $data->save();
                    if ($data) {
                        foreach ($timeSlots as $slot_data) {
                            $data_detail = new Slot_Details();
                            $data_detail->slot_id = $data->id;
                            $data_detail->start_time = $slot_data['start'];
                            $data_detail->end_time = $slot_data['end'];
                            $data_detail->duration = $duration;
                            $data_detail->is_available = 0;
                            $data_detail->save();
                        }
                    }
                }
                else
                {
                  return response()->json(['status' => '1', 'success' => 'For This Slot Already Added.']);
                }
              }

            }

            if (!empty($data_detail)) {
                return response()->json(['status' => '1', 'success' => 'Data Added Successfully.']);
            }

        } catch (Exception $ex) {
            return response()->json(
                ['success' => false, 'message' => $ex->getMessage()]
            );
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
