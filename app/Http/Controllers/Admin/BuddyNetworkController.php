<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BuddyNetwork;
use App\Models\BuddyNetworkDetail;
use DataTables;
use Illuminate\Http\Request;
use URL;

class BuddyNetworkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        if ($request->ajax()) {
            $data = BuddyNetwork::where('is_delete', 0)->with('user_data')->orderBY('id','DESC')->get();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $alert_delete = "return confirm('Are you sure want to delete !')";
                    $btn = "<ul class='action'>";
                    $btn = $btn . ' <li class="show"> <a class="show-data"  href="javascript:void(0)" title="Show" data-url="' . route('buddy-network.show', $row->id) . '"><i class="icon-eye"></i></a></li> </ul>';
                    return $btn;

                })

                ->addColumn('user_details', function ($data) {
                    if ($data->user_data->profile_image == null && $data->user_data->profile_image == "") {
                        return '<ul>
                        <li>
                          <div class="media"><img class="b-r-8 img-40" src=' . URL::to('/public') . '/admin/assets/images/user/user.png' . '  alt="Generic placeholder image"> <div class="media-body">
                          <div class="row">
                            <div class="col-xl-12">
                            <h6 class="mt-0">&nbsp;&nbsp; ' . $data->user_data->first_name . " " . $data->user_data->last_name . '</span></h6>
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
                            <h6 class="mt-0">&nbsp;&nbsp; ' . $data->user_data->first_name . " " . $data->user_data->last_name . '</span></h6>
                            </div>
                            </div>
                            <p>&nbsp;&nbsp; ' . $data->user_data->email . '</p>
                        </div>
                        </div>
                    </li>
                    </ul>';
                }
                })


                ->rawColumns(['action', 'user_details','referal_code'])
                ->make(true);
        }
        return view('Admin.BuddyNetwork.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        try {
            $data = BuddyNetworkDetail::where('buddy_network_id', $id)->where('is_delete',0)->with('user_data')->get();
            if (!empty($data)) {
                return view('Admin.BuddyNetwork.show', compact('data'));
            }
        } catch (Exception $ex) {
            return response()->json(
                ['success' => false, 'message' => $ex->getMessage()]
            );
        }
    }

}
