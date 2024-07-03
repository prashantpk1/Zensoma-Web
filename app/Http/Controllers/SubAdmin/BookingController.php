<?php

namespace App\Http\Controllers\SubAdmin;

use URL;
use Image;
use DateTime;
use stdClass;
use DataTables;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Booking;
use App\Models\Slot_Details;
use Illuminate\Http\Request;
use App\Services\ZoomService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{

    protected $zoomService;

    public function __construct(ZoomService $zoomService)
    {
        $this->zoomService = $zoomService;
    }

    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = Booking::with('user_data')->where('therapist_id',Auth::user()->id)->orderBY('id','DESC')->get();
            return Datatables::of($data)->addIndexColumn()
              ->addColumn('action', function ($row) {
                    $alert_delete = "return confirm('Are you sure want to delete !')";
                    $btn = "<ul class='action'>";

                       // Get the current date and time
                        $currentDateTime = "";
                        $today_date = "";
                        $currentDateTime = Carbon::now();
                        $today_date  =  $currentDateTime->format('Y-m-d');

                        $today_time =   date('H:i:s');


                        // Create a DateTime object for the current time
                        $current_time = new DateTime($today_time);
                       
                        // Format the new time as a string
                        $new_time = $current_time->format('H:i:s');

                        $startDateTime = $row->start_time;
                        $endDateTime = $row->end_time;
                        $checkDateTime = $new_time;


                       // Format the date and time to the desired format
                    $btn = '';

                if ($today_date == $row->date) {
                    // If the current date matches the meeting date
                    if ($checkDateTime >= $startDateTime && $checkDateTime <= $endDateTime) {
                        // If the current time is within the meeting start and end times
                        $btn .= '<span class="Join Meeting"><a href="' . route('create.session', $row->id) . '" class="create_session" title="Join Meeting"> <i class="icon-eye"></i>  </a></span>';
                    } elseif ($checkDateTime < $startDateTime) {
                        // If the current time is before the meeting start time
                        $btn .= '<span class="Waiting for meeting">Waiting for meeting</span>';
                    } else {
                        // If the current time is after the meeting end time
                        $btn .= '<span class="Meeting is complete">Meeting is complete</span>';
                    }
                } else {
                    // If the current date does not match the meeting date
                    if ($today_date > $row->date) {
                        // If the meeting date is in the past
                        $btn .= '<span class="Waiting for meeting">Meeting is complete</span>';
                    } else {
                        // If the meeting date is in the future
                        $btn .= '<span class="Meeting is complete">Waiting for meeting</span>';
                    }
                }


                    $btn =  $btn . "</ul>";

                       return $btn;
                })


                ->addColumn('user_detail', function ($data) {
                    if ($data->user_data->profile_image == null && $data->user_data->profile_image == "") {
                        return '<ul>
                        <li>
                          <div class="media"><img class="b-r-8 img-40" src=' . URL::to('/public') . '/admin/assets/images/user/user.png' . '  alt="Generic placeholder image"> <div class="media-body">
                          <div class="row">
                            <div class="col-xl-12">
                            <h6 class="mt-0">&nbsp;&nbsp; ' . $data->user_data->name . '</span></h6>
                            </div>
                          </div>
                          <p>&nbsp;&nbsp; ' . $data->user_data->email . '</p>
                        </div>
                      </div>
                    </li>
                  </ul>';
                    } else {

                    return ' <ul>
                    <li>
                        <div class="media"><img class="b-r-8 img-40" src=' . URL::to('/public') . '/profile_image/' . $data->user_data->profile_image . '  alt="Generic placeholder image">
                        <div class="media-body">
                            <div class="row">
                            <div class="col-xl-12">
                            <h6 class="mt-0">&nbsp;&nbsp; ' . $data->user_data->name . '</span></h6>
                            </div>
                            </div>
                            <p>&nbsp;&nbsp; ' . $data->user_data->email . '</p>
                        </div>
                        </div>
                    </li>
                    </ul>';
                }
                })

                ->addColumn('status', function ($data) {
                    if ($data->status == "confirm") {
                        return '<span class="badge bg-success">Confirm</span>';
                    }elseif($data->status == "complete") {
                       return  '<span class="badge bg-info">Complete</span>';
                    }elseif ($data->status == "pending") {
                        return  '<span class="badge bg-info">pending</span>';
                    } else {
                        return '<span class="badge bg-danger">'.$data->status.'</span>';
                    }
                })

                ->rawColumns(['action', 'status','user_detail'])
                ->make(true);
        }
        return view('SubAdmin.Booking.index');
    }

  
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        // try {
        //     $data = Booking::find($id);
        //     if (!empty($data)) {
        //         return view('SubAdmin.Booking.show', compact('data'));
        //     }
        // } catch (Exception $ex) {
        //     return response()->json(
        //         ['success' => false, 'message' => $ex->getMessage()]
        //     );
        // }

    }

     /**
     * Remove the specified resource from storage.
     */
    public function joinMeeting(string $id)
    {
        //
        $api_key = "UtCjrDBRZyjJE6RjKkFmQ";
        $api_secret = "ckc927nlOxqEfmEt6a1PTr2aav8Ho6Ic";
        $booking =  Booking::find($id);
        $user =  User::find($booking->therapist_id);

        $meetingNumber  = $booking->meeting_id;
        $passWord  = $booking->meeting_password;
        $userName = $user->name ?? "Sub Admin";
        $role = "1";
        $url = url()->previous();
        return view('join_meeting', compact('api_key', 'api_secret', 'meetingNumber', 'passWord', 'userName', 'role', 'url'));
        
  
    }


    public function createSession($id)
    {
        $data = Booking::find($id);
        // dd($data);
        $user = User::where('id',$data->therapist_id)->first();

        if(empty($data->session_token)) {
            $slot_detail = Slot_Details::with('slot_info')->find($data->slot_id);
            $session_name = $slot_detail->slot_info->title ?? "Custom Slot";
            $output = str_replace(' ', '_', $session_name);
            $sessionName = ucfirst($output);
            $name = $user->first_name . " " . $user->last_name;
            $session_data = ['role'=>1,'sessionName'=>$sessionName,'username'=>$name ?? "Sub Admin"];
            $session = $this->zoomService->createSession($session_data);

            // Extract the original data from the response
            $response_data = $session->original;
            
            // Extract token and sessionName
            $data->session_token = $response_data['token'];
            $data->session_name = $response_data['sessionName'];
            $data->update();
        }
        $data['username'] = $user->first_name . " " . $user->last_name;
        return view('SubAdmin.join_session', compact('data'));


    }
}
