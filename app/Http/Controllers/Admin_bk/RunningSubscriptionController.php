<?php

namespace App\Http\Controllers\Admin;


use DataTables;
use Illuminate\Http\Request;
use App\Models\UserSubscription;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;

class RunningSubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //

        if ($request->ajax()) {
            $data = UserSubscription::with('user_data','subscription')->where('status','active')->orderBY('id','DESC')->get();
            return Datatables::of($data)->addIndexColumn()


                ->addColumn('status', function ($data) {
                    if ($data->status == "active") {
                        return '<span class="badge bg-success">Active</span>';
                    }else {
                        return '<span class="badge bg-info">InActive</span>';
                    }
                })



                ->addColumn('created_at', function ($data) {
                    return date('Y-M-d h:i A', strtotime($data->created_at));

                })

                ->addColumn('subscription_name', function ($data) {
                    return $data->subscription->key;

                })


                ->addColumn('user_detail', function ($data) {
                    if ($data->user_data->profile_image == null && $data->user_data->profile_image == "") {
                        return ' <ul>
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

                ->rawColumns(['status','user_detail','subscription_name'])
                ->make(true);
        }
        return view('Admin.Running-Subscription.index');
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
