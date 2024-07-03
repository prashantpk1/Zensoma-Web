<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CustomizedNotificationRequest;
use App\Models\CustomizedNotification;
use App\Models\User;
use  Mail;
use DataTables;
use Illuminate\Support\Facades\DB;

class CustomizedNotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        if ($request->ajax()) {
            $data = CustomizedNotification::where('is_delete',0)->orderBY('id','DESC')->get();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $alert_delete = "return confirm('Are you sure want to delete !')";
                    $btn = "<ul class='action'>";
                    $btn = $btn . ' <li class="delete"><a href="" data-url="' . route('notification.destroy', $row->id) . '" class="destroy-data" title="Delete"> <i class="icon-trash"></i></a></li> </ul>';
                    return $btn;

                })


                ->addColumn('status', function ($data) {
                    if ($data->status == 1) {
                        return '<span class="badge bg-success">Active</span>';
                    } else {
                        return '<span class="badge bg-danger">In-Active</span>';
                    }
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('Admin.Customized-Notifications.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('Admin.Customized-Notifications.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomizedNotificationRequest $request)
    {


        try {
            $post = $request->all();
            $notification_type = $request->notification_type;
            $user_type = $request->user_type;
            $title = $request->title;
            $content = $request->content;
            $data = new CustomizedNotification();
            $data->title = $request->title;
            $data->content = $request->content;
            $data->notification_type = $request->notification_type;
            if($request->user_type = 0)
            {
                  $user_type = "customer";
            }elseif ($request->user_type = 1) {
                  $user_type = "subadmin";
            }
            else {
                $user_type = "both";
            }
            $data->user_type = $user_type;
            $data->status = 1;
            $data->save();
            if (!empty($data)) {
                          if($user_type == "0")
                          {
                                $user_data = User::where('user_type',0)->where('is_delete',0)->where('is_approved',1)->get();
                          }
                          else if($user_type == "1"){
                                $user_data = User::where('user_type',1)->where('is_delete',0)->where('is_approved',1)->get();
                          }
                          else
                          {
                               $user_data = User::where('is_delete',0)->where('is_approved',1)->get();
                          }


                            if($notification_type  == "email"){

                                                if($user_data){
                                                        foreach($user_data as $user){
                                                        $email = $user['email'];

                                                                        Mail::send(
                                                                            ['html' => 'email.customized_notication_email_template'],
                                                                            array(
                                                                                'title'    =>$title,
                                                                                'content'  =>$content,
                                                                            ),
                                                                            function ($message) use ($email) {
                                                                                $message->from(env('MAIL_USERNAME'), 'Zensoma');
                                                                                $message->to($email);
                                                                                $message->subject("New Alert From Zensoma...");
                                                                            }
                                                        );
                                                    }
                                                }
                            }
                            else if($notification_type == "push_notification"){
                                        foreach($user_data as $user){

                                            $check_send_notification =  send_notifications($user->id,$user->fcm_token ?? 0,$user->device_type ?? "Android","Push_notification","new_notification","New Notification From Admin");

                                        }

                            }
                            else
                            {


                                if($user_data){
                                    foreach($user_data as $user){
                                    $email = $user['email'];

                                                    Mail::send(
                                                        ['html' => 'email.customized_notication_email_template'],
                                                        array(
                                                            'title'    =>$title,
                                                            'content'  =>$content,
                                                        ),
                                                        function ($message) use ($email) {
                                                            $message->from(env('MAIL_USERNAME'), 'Zensoma');
                                                            $message->to($email);
                                                            $message->subject("New Alert From Zensoma...");
                                                        }
                                    );


                                    $check_send_notification =  send_notifications($user->id,$user->fcm_token ?? 0,$user->device_type ?? "Android","Push_notification","new_notification","New Notification From Admin");
                                }
                            }

                            }


                return response()->json(['status' => '1', 'success' => 'Notification Send successfully.']);
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
        try {
            DB::beginTransaction();
            $data = CustomizedNotification::find($id);
            $data->is_delete = 1;
            $data->update();
            DB::commit(); // Commit Transaction
            return response()->json(['status' => '1', 'success' => 'Notification deleted successfully']);
        } catch (\Exception $e) {
            DB::rollBack(); //Rollback Transaction
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
