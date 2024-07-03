<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\BuddyResource;
use App\Http\Resources\BuddySessionDetailResource;
use App\Models\BuddyNetwork;
use App\Models\BuddyNetworkDetail;
use App\Models\MySession;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuddyController extends Controller
{
    //
    public function buddyList(Request $request)
    {

        try {
            $language_code = $request->header('language');
            $id = Auth::user()->id;
            $data = BuddyNetwork::where('user_id', $id)->where('is_delete', 0)->first();
            if ($data) {

                $buddy = BuddyNetworkDetail::with('user_data')->where('buddy_network_id', $data->id)->where('is_delete', 0);

                            if (!empty($request->search)) {

                                $buddy->whereHas('user_data', function ($q) use ($request) {
                                    $q->where('name', 'LIKE', '%' . $request->search . '%');
                                });

                            }


                $total = $buddy->count();
                $data1 = $buddy->paginate(10);
                $buddy_data = BuddyResource::collection($data1);
                return response()->json(
                    [
                        'data' => $buddy_data,
                        'total' => $total,
                        'status' => 1,
                        'message' =>  get_label("buddy_list_get_successfully",$language_code),
                    ], 200);
            } else {
                return response()->json(
                    [
                        'status' => 0,
                        'message' => get_label("somthing_went_wrong",$language_code),
                    ], 200);
            }

        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }

    }

    public function addBuddy(Request $request)
    {

        $language_code = $request->header('language');
        $validated = [];
        $validated['user_id'] = "required";

        $customMessages = [
            'user_id.required' => get_label("the_user_id_field_is_required",$language_code),
        ];

        $request->validate($validated, $customMessages);

        try {
            $id = Auth::user()->id;
            $referral_code = Auth::user()->referral_code;
            $data = BuddyNetwork::where('user_id', $id)->where('is_delete', 0)->first();

            if ($data) {


                $data2 = BuddyNetworkDetail::where('buddy_network_id', $data->id)->where('user_id', $request->user_id)->where('is_delete', 0)->first();

              $check_user_id = User::find($request->user_id);
                if ($check_user_id) {
                    if (empty($data2)) {
                        $buddy = BuddyNetworkDetail::create([
                            "buddy_network_id" => $data->id,
                            "user_id" => $request->user_id,
                            "status" => 1,
                            "is_delete" => 0,
                        ]);


                        $data3 = BuddyNetwork::where('user_id', $request->user_id)->where('is_delete', 0)->first();

                        if(!empty($data3)) {
                                    $buddy = BuddyNetworkDetail::create([
                                        "buddy_network_id" => $data3->id,
                                        "user_id" => $id,
                                        "status" => 1,
                                        "is_delete" => 0,
                                    ]);
                        }


                        return response()->json(
                            [
                                'status' => 1,
                                'message' => get_label("buddy_added_successfully_to_buddy_list",$language_code),
                            ], 200);
                    } else {
                        return response()->json(
                            [
                                'status' => 0,
                                'message' => get_label("buddy_already_added_to_buddy_list",$language_code),
                            ], 200);
                    }

                } else {


                    return response()->json(
                        [
                            'status' => 0,
                            'message' => get_label("user_not_found",$language_code),
                        ], 200);
                }

            }
            else {


                return response()->json(
                    [
                        'status' => 0,
                        'message' => get_label("user_not_found",$language_code),
                    ], 200);
            }

        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }

    }

    public function removeBuddy(Request $request)
    {

        $language_code = $request->header('language');
        $validated = [];
        $validated['buddy_network_id'] = "required";

        $customMessages = [
            'buddy_network_id.required' => get_label("the_buddy_network_id_field_is_required",$language_code),
        ];

        $request->validate($validated, $customMessages);

        try {

            $data = BuddyNetworkDetail::find($request->buddy_network_id);
            if ($data) {
                $data->is_delete = 1;
                $data->update();
                return response()->json(
                    [
                        'status' => 0,
                        'message' => get_label("buddy_delete_from_buddy_network_list",$language_code),
                    ], 200);
            } else {
                return response()->json(
                    [
                        'status' => 0,
                        'message' =>  get_label("buddy_network_Id_not_found",$language_code),
                    ], 200);
            }

        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }

    }

    //get user my-session
    public function getBuddySessionDetail(Request $request)
    {
        $language_code = $request->header('language');


        $validated = [];
        $validated['buddy_user_id'] = "required";

        $customMessages = [
            'buddy_user_id.required' => get_label("the_buddy_user_id_field_is_required",$language_code),
        ];

        $request->validate($validated, $customMessages);

        try {
            $data = MySession::with('session_data')->where("user_id", $request->buddy_user_id)->where('is_delete', 0)->paginate(10);
            $data1 = BuddySessionDetailResource::collection($data);
            return response()->json([
                'data' => $data1,
                'status' => '1',
                'success' => get_label("buddy_session_data_get_successfully",$language_code),
            ]);
        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }
    }

}
