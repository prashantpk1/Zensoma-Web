<?php

namespace App\Http\Controllers\API\V1;

use App\Models\User;
use App\Models\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SubAdminResource;
use App\Http\Resources\SubAdminDetailResource;

class SubAdminController extends Controller
{
    //

    public function getTherapists(Request $request)
    {

        $language_code = $request->header('language');
        $language = Language::where('code', $language_code)->where('status', 1)->where('is_delete', 0)->first();
        if (empty($language)) {
            return response()->json(
                ['status' => 0, 'message' => 'Invalied Language Code'], 401
            );
        }

        try {


            $subadmin  = User::where('user_type', 1)->where('is_delete', 0);

            if ($request->search) {
                $subadmin->where('name', 'LIKE', '%' . $request->search . '%');
            }


            $total = $subadmin->count();
            $data = $subadmin->paginate(10);


            $sub_admin_data = SubAdminResource::collection($data);
            return response()->json(
                [
                    'data' => $sub_admin_data,
                    'status' => 1,
                    'total' => $total ?? 0,
                    'message' => get_label("therapist_list_get_successfully",$language_code),
                ], 200);
        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }

    }

    public function getTherapistDetail(Request $request,$id)
    {
        $language_code = $request->header('language');
        $language = Language::where('code', $language_code)->where('status', 1)->where('is_delete', 0)->first();
        if (empty($language)) {
            return response()->json(
                ['status' => 0, 'message' => 'Invalied Language Code'], 401
            );
        }

        try {
            $data = User::find($id);
            $sub_admin_detail = new SubAdminDetailResource($data);
            return response()->json(
                [
                    'data' => $sub_admin_detail,
                    'status' => 1,
                    'message' => get_label("therapist_detail_get_successfully",$language_code),
                ], 200);
        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }

    }

}
