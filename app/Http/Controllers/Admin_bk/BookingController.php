<?php

namespace App\Http\Controllers\Admin;

use URL;
use Image;
use DataTables;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //

        if ($request->ajax()) {
            $data = Booking::with('user_data','therapist_data')->orderBY('id','DESC')->get();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $alert_delete = "return confirm('Are you sure want to delete !')";
                    $btn = "<ul class='action'>";
                    $btn = $btn . ' <li class="show"> <a class="show-data"  href="javascript:void(0)" title="Show" data-url="' . route('booking.show', $row->id) . '"><i class="icon-eye"></i></a></li> </ul>';
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


                ->addColumn('tharapist_detail', function ($data) {
                    if ($data->therapist_data->profile_image == null && $data->therapist_data->profile_image == "") {
                        return '<ul>
                        <li>
                          <div class="media"><img class="b-r-8 img-40" src=' . URL::to('/public') . '/admin/assets/images/user/user.png' . '  alt="Generic placeholder image"> <div class="media-body">
                          <div class="row">
                            <div class="col-xl-12">
                            <h6 class="mt-0">&nbsp;&nbsp; ' . $data->therapist_data->name . '</span></h6>
                            </div>
                          </div>
                          <p>&nbsp;&nbsp; ' . $data->therapist_data->email . '</p>
                        </div>
                      </div>
                    </li>
                  </ul>';
                    } else {

                    return ' <ul>
                    <li>
                        <div class="media"><img class="b-r-8 img-40" src=' . URL::to('/public') . '/profile_image/' . $data->therapist_data->profile_image . '  alt="Generic placeholder image">
                        <div class="media-body">
                            <div class="row">
                            <div class="col-xl-12">
                            <h6 class="mt-0">&nbsp;&nbsp; ' . $data->therapist_data->name . '</span></h6>
                            </div>
                            </div>
                            <p>&nbsp;&nbsp; ' . $data->therapist_data->email . '</p>
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

                ->rawColumns(['action', 'status','user_detail','tharapist_detail'])
                ->make(true);
        }
        return view('Admin.Booking.index');
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
        // try {
        //     $data = Booking::find($id);
        //     if (!empty($data)) {
        //         return view('Admin.Booking.show', compact('data'));
        //     }
        // } catch (Exception $ex) {
        //     return response()->json(
        //         ['success' => false, 'message' => $ex->getMessage()]
        //     );
        // }

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
