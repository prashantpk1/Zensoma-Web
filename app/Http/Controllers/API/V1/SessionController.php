<?php

namespace App\Http\Controllers\API\V1;

use Carbon\Carbon;
use App\Models\Wallet;
use App\Models\Language;
use App\Models\MySession;
use App\Models\MyFavorite;
use App\Models\UserDetails;
use App\Models\CategoryType;
use Illuminate\Http\Request;
use App\Models\ChallengeFriend;
use App\Models\UserSubscription;
use App\Models\ContentManagement;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\SessionResource;
use App\Http\Resources\MySessionResource;
use App\Http\Resources\SessionDetailResource;
use App\Http\Resources\MyFavoriteSessionResource;

class SessionController extends Controller
{


    //get sesion full detail
    public function sessionDetail(Request $request)
    {
        $language_code = $request->header('language');
        $language = Language::where('code', $language_code)->where('status', 1)->where('is_delete', 0)->first();
        if (empty($language)) {
            return response()->json(
                ['status' => 0, 'message' => 'Invalied Language Code'], 401
            );
        }

        $validated = [];
        $validated['session_id'] = "required";
        $customMessages = [
            'session_id.required' => get_label("the_session_id_field_is_required",$language_code),
        ];

        $request->validate($validated, $customMessages);

        $session = ContentManagement::with('session_videos')->where('id', $request->session_id)->where('is_delete', 0)->first();
        if (empty($session)) {
            return response()->json(
                ['status' => 0, 'message' => get_label("session_not_found",$language_code)], 401
            );
        }
        try {

            $today_date = Carbon::now()->format('Y-m-d');

            if (!empty($request->user_id)) {

                //get user subscription detail
                $user_sub = UserSubscription::with('subscription')->where('user_id', $request->user_id)->where('status', 'active')->where('end_date', '>=', $today_date)->first();

                if ($user_sub) {

             
                    //check favorite list start
                    if (MyFavorite::where('user_id', $request->user_id)->where('session_id', $session->id)->exists()) {
                        $session->my_favourite = 1;
                    } else {
                        $session->my_favourite = 0;
                    }
                    //check favorite list end


                    //check chellage
                    $check_challenge = ChallengeFriend::where('challenge_to', $request->user_id)->where('session_id', $session->id)->first();
                    if (!empty($check_challenge)) {
                        $session->challenge_recived = 1;
                        $session->challenge_id = $check_challenge->id;
                        $session->challenge_status = $check_challenge->status;
                    } else {
                        $session->challenge_recived = 0;
                        $session->challenge_id = 0;
                        $session->challenge_status = "";
                    }
                    //check chellage

                    //add key for perchase check start
                    if ($session->purchase_type != 1) {
                        if ($user_sub->subscription) {
                            if ($user_sub->subscription->subscription_type == "whole_system") {
                                $session->is_available = 1;
                            } else {
                                $array1 = $user_sub->subscription->category_id;
                                $category_id = $session->category_id;
                                $array2 = json_decode($category_id);

                                $common_values = array_intersect($array1, $array2);
                                if (!empty($common_values)) {
                                    $session->is_available = 1;
                                } else {
                                    $session->is_available = 0;
                                }
                            }
                        } else {
                            $session->is_available = 0;
                        }
                    } else {
                        $session->is_available = 0;
                    }

                }
                else
                 {
                  
                    $session->is_available = 0;

                      //check favorite list start
                      if (MyFavorite::where('user_id', $request->user_id)->where('session_id', $session->id)->exists()) {
                        $session->my_favourite = 1;
                        } else {
                            $session->my_favourite = 0;
                        }
                        //check favorite list end


                      //check chellage
                      $check_challenge = ChallengeFriend::where('challenge_to', $request->user_id)->where('session_id', $session->id)->first();
                      if (!empty($check_challenge)) {
                          $session->challenge_recived = 1;
                          $session->challenge_id = $check_challenge->id;
                          $session->challenge_status = $check_challenge->status;
                      } else {
                          $session->challenge_recived = 0;
                          $session->challenge_id = 0;
                          $session->challenge_status = "";
                      }
                      //check chellage
                }

                  //add key for my_session 
                    foreach($session->session_videos as $video){
                        $video_check = MySession::where('user_id',$request->user_id)->where('session_video_id',$video->id)->where('session_id',$request->session_id)->first();
                        $video["my_session"] =  $video_check ?? " ";
                    }
                    //add key for my_session 

            } else {

                $session = ContentManagement::with('session_videos')->find($request->session_id);
                $session->is_available = 0;
                $session->my_favourite = 0;
                $session->challenge_recived = 0;
                $session->challenge_id = 0;
                $session->challenge_status = "";
            }

            //add key for perchase check end

            

            $session_data = new SessionDetailResource($session);
            return response()->json(
                [
                    'data' => $session_data,
                    'status' => 1,
                    'message' => get_label("session_detail_get_successfully",$language_code),
                ], 200);

        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }

    }

    //add session to my sesion
    public function addUpdateSessionToMySession(Request $request)
    {


        $language_code = $request->header('language');
        $language = Language::where('code', $language_code)->where('status', 1)->where('is_delete', 0)->first();
        if (empty($language)) {
            return response()->json(
                ['status' => 0, 'message' => 'Invalied Language Code'], 401
            );
        }

        $validated = [];
        $validated['session_id'] = "required";
        $validated['session_video_id'] = "required";
        $validated['status'] = "required";
        $validated['push_time'] = "required_if:status,0";


        $customMessages = [
            'session_id.required' => get_label("the_session_id_field_is_required",$language_code),
            'session_video_id.required' => get_label("the_session_video_id_field_is_required",$language_code),
            'status.required' => get_label("the_status_field_is_required",$language_code),
            'push_time.required_if' =>  get_label("the_push_time_is_required_when_the_status_is_0",$language_code),
        ];

        $request->validate($validated, $customMessages);

        try {
            $check_session_data = MySession::where("user_id", Auth::user()->id)->where("session_id", $request->session_id)->where("session_video_id", $request->session_video_id)->first();
            if (!empty($check_session_data)) {

                //add point for video
                if($check_session_data->status == 0)
                {

                    if($request->status == 1)
                    {
                        $amount  =  get_point_amount("watch_video_to_earn");
                        if($amount >= 0) {
                            $user_wallet = new Wallet();
                            $user_wallet->user_id  = $check_session_data->user_id;
                            $user_wallet->type = "credit";
                            $user_wallet->amount = $amount;
                            $user_wallet->save();
                        }

                    }
                }
                //add point for video

                //check session is complate or not
                if($check_session_data->status == 0)
                {
                    $check_session_data->status = $request->status;
                }
                //check session is complate or not

                if (!empty($request->push_time)) {
                    $check_session_data->push_time = $request->push_time;
                    $time_parts = explode(':', $request->push_time);
                    $check_session_data->minute_spend = $time_parts[0];

                }

                $check_session_data->save();

                 //gamification cal
                 get_total_minute(Auth::user()->id);
                 gamification_cal(Auth::user()->id);
                 //gamification cal


                if (!empty($check_session_data)) {
                    return response()->json(['status' => 1, 'success' =>  get_label("my_session_update_successfully",$language_code)]);
                }

            } else {

                $session_data = ContentManagement::find($request->session_id);
                $data = new MySession();
                $data->session_id = $request->session_id;
                $data->session_video_id = $request->session_video_id;
                $data->user_id = Auth::user()->id;
                $data->category_id = $session_data->category_id ?? "";
                if (!empty($request->push_time)) {
                    $data->push_time = $request->push_time;
                }
                $data->status = $request->status;
                $data->save();

                if($request->status == 1)
                {
                    $amount  =  get_point_amount("watch_video_to_earn");
                    if($amount >= 0) {
                        $user_wallet = new Wallet();
                        $user_wallet->user_id  = Auth::user()->id;
                        $user_wallet->type = "credit";
                        $user_wallet->amount = $amount;
                        $user_wallet->save();
                    }
                }

                //gamification cal
                get_total_minute(Auth::user()->id);
                //gamification cal

                if (!empty($data)) {
                    return response()->json(['status' => '1', 'success' => get_label("my_session_added_successfully",$language_code)]);
                }

            }
        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }

    }

    //get user my-session
    public function mySessions(Request $request)
    {


        $language_code = $request->header('language');
        $language = Language::where('code', $language_code)->where('status', 1)->where('is_delete', 0)->first();
        if (empty($language)) {
            return response()->json(
                ['status' => 0, 'message' => 'Invalied Language Code'], 401
            );
        }

        $validated = [];
        $validated['category_id'] = "required";

        $customMessages = [
            'category_id.required' => get_label("the_category_id_field_is_required",$language_code),
        ];

        $request->validate($validated, $customMessages);


        try {
            $query = MySession::with('session_data');

            if (!empty($request->search)) {

                $query->whereHas('session_data', function ($q) use ($request) {
                    $q->where('title', 'LIKE', '%' . $request->search . '%');
                });

            }

            $query->where('user_id', Auth::user()->id)->whereJsonContains('category_id', ["$request->category_id"]);
            $total = $query->count();
            $query = $query->paginate(10);


            if (!empty($query)) {
                $my_session = MySessionResource::collection($query);
                return response()->json([
                    'data' => $my_session,
                    'status' => '1',
                    'total' => $total,
                    'success' => get_label("my_session_get_successfully",$language_code),
                ]);
            } else {
                return response()->json([
                    'status' => '1',
                    'success' => get_label("session_not_found",$language_code),
                ]);
            }
        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }
    }

    //get user my-session
    public function myFavoriteSession(Request $request)
    {

        $language_code = $request->header('language');
        $language = Language::where('code', $language_code)->where('status', 1)->where('is_delete', 0)->first();
        if (empty($language)) {
            return response()->json(
                ['status' => 0, 'message' => 'Invalied Language Code'], 401
            );
        }

        try {
            $data = MyFavorite::with('MySession')->where("user_id", Auth::user()->id)->where('is_delete', 0)->paginate(10);
            $data1 = MyFavoriteSessionResource::collection($data);
            return response()->json([
                'data' => $data1,
                'status' => '1',
                'success' =>  get_label("my_session_get_successfully",$language_code),
            ]);
        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }
    }




     //get all session list
     public function sessions(Request $request)
     {
         $language_code = $request->header('language');
         $language = Language::where('code', $language_code)->where('status', 1)->where('is_delete', 0)->first();
         if (empty($language)) {
             return response()->json(
                 ['status' => 0, 'message' => 'Invalied Language Code'], 401
             );
         }

         $validated = [];
         $validated['category_id'] = "required";
         $validated['type_id'] = "required";

         $customMessages = [
            'category_id.required' => get_label("the_category_id_field_is_required",$language_code),
            'type_id.required' => get_label("the_type_id_field_is_required",$language_code),
        ];

        $request->validate($validated, $customMessages);

         $language_name = $request->header('language');

         try {

             if ($request->type_id != 0) {


                 $today_date = Carbon::now()->format('Y-m-d');
                 if (!empty($request->user_id)) {

                     //get user subscription detail
                     $user_sub = UserSubscription::with('subscription')->where('user_id', $request->user_id)->where('status', 'active')->where('end_date', '>=', $today_date)->first();

                     if ($user_sub) {

                         $data = ContentManagement::with('session_video_first')->where('status', 1)->where('is_delete', 0)->where('type_id', $request->type_id);
                         $total = $data->count();
                         $data = $data->paginate(10);
                         foreach ($data as $session) {

                             //check favorite list start
                             if (MyFavorite::where('user_id', $request->user_id)->where('session_id', $session->id)->exists()) {
                                 $session->my_favourite = 1;
                             } else {
                                 $session->my_favourite = 0;
                             }
                             //check favorite list end

                             //add key for perchase check start
                             if ($session->purchase_type != 1) {
                                 if ($user_sub->subscription) {
                                     if ($user_sub->subscription->subscription_type == "whole_system") {
                                         $session->is_available = 1;
                                     } else {
                                         $array1 = $user_sub->subscription->category_id;
                                         $category_id = $session->category_id;
                                         $array2 = json_decode($category_id);

                                         $common_values = array_intersect($array1, $array2);
                                         if (!empty($common_values)) {
                                             $session->is_available = 1;
                                         } else {
                                             $session->is_available = 0;
                                         }
                                     }
                                 } else {
                                     $session->is_available = 0;
                                 }
                             } else {
                                 $session->is_available = 0;
                             }

                             //add key for perchase check end
                         }

                     } else {
                         $query = ContentManagement::with('session_video_first')->where('status', 1)->where('is_delete', 0);
                         if ($request->type_id) {
                             $query->where('type_id', $request->type_id);
                         }

                         $data = $query->paginate(10);
                         foreach ($data as $session) {
                             $session->my_favourite = 0;
                             $session->is_available = 0;
                         }
                     }

                 } else {

                     $query = ContentManagement::with('session_video_first')->where('status', 1)->where('is_delete', 0);
                     if ($request->type_id) {
                        $query->where('type_id', $request->type_id);
                     }
                     $data = $query->paginate(10);

                     foreach ($data as $session) {
                         $session->my_favourite = 0;
                         $session->is_available = 0;
                     }

                 }

                 $session_data = SessionResource::collection($data);

             } else {


                 $today_date = Carbon::now()->format('Y-m-d');
                 $cate_data = CategoryType::where('category_id', $request->category_id)->get();
                 $result = [];
                 foreach ($cate_data as $cate) {

                     $type_name = json_decode($cate->type);
                     $type = $type_name->$language_name->type;
                     $cate['type_name'] = $type;

                     $data = ContentManagement::with('session_video_first')->select('id', 'title', 'file', 'thumbnail', 'content_type', 'creater_id', 'creater_name', 'creater_type', 'category_id')->where('status', 1)->where('is_delete', 0)->where('type_id', $cate->id)->limit(5)->get();

                     foreach ($data as $d) {

                         $title = "";
                         $title_name = json_decode($d->title);
                         $title = $title_name->$language_name->title;
                         $d['title'] = $title ?? "";
                         $d['type_id'] = $d->type_id ?? "";
                         $d['file'] = URL::to('/public') . '/file/' . $d->session_video_first->video_audio_file;
                         $d['thumbnail_image'] = URL::to('/public') . '/thumbnail_image/' . $d->session_video_first->thumbnail_image;

                         if ($request->user_id) {
                             $user_sub = UserSubscription::with('subscription')->where('user_id', $request->user_id)->where('status', 'active')->where('end_date', '>=', $today_date)->first();
                             if ($user_sub) {


                                 if ($user_sub->subscription->subscription_type == "whole_system") {
                                         $d['is_available'] = 1;
                                 } else {
                                     $array1 = $user_sub->subscription->category_id;
                                     $category_id = $d->category_id;
                                     $array2 = json_decode($category_id);

                                     $common_values = array_intersect($array1, $array2);
                                     if (!empty($common_values)) {
                                         $d['is_available'] = 1;
                                     } else {
                                         $d['is_available'] = 0;
                                     }
                                 }


                             } else {
                                 $d['is_available'] = 0;
                             }
                         } else {
                             $d['is_available'] = 0;
                         }

                     }

                     $cate['content_data'] = $data->toArray();

                 }

                 $session_data = $cate_data;

             }

             return response()->json(
                 [
                     'data' => $session_data,
                     'status' => 1,
                     'total' => $total ?? 0,
                     'message' => get_label("session_list_get_successfully",$language_code),
                 ], 200);

         } catch (Exception $ex) {
             return response()->json(
                 ['success' => 0, 'message' => $ex->getMessage()], 401
             );
         }

     }


}
