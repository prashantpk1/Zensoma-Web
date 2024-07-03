<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Language;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\NotificationResource;

class NotificationController extends Controller
{
    //

    public function  notification(Request $request)
    {

        $language_code = $request->header('language');
        $language = Language::where('code', $language_code)->where('status', 1)->where('is_delete', 0)->first();
        if (empty($language)) {
            return response()->json(
                ['status' => 0, 'message' => 'Invalied Language Code'], 401
            );
        }


              $id= Auth::user()->id;
              $data = Notification::where("user_id",$id)->select('id','notification_type','notification_message','is_read','created_at')->orderBy('id','Desc');
              $total = $data->count();
              $data = $data->paginate(10);
              $result = NotificationResource::collection($data);

              foreach($data  as $notification)
              {
                  $notification= Notification::find($notification->id);
                  $notification->is_read = 1;
                  $notification->update();

              }

              if($result) {
                return response()->json(
                    [
                        'data' => $result,
                        'status' => 1,
                        'total' => $total,
                        'message' => get_label("notification_list_get_succesfully",$language_code),
                    ], 200);
                }
                else
                {
                    return response()->json(
                            [
                                'status' => 1,
                                'message' => get_label("no_notification_found",$language_code),
                            ], 200);

                }

    }

}
