<?php

namespace App\Http\Controllers\Admin;

use URL;
use DataTables;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PredefinedAnswer;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\Admin\CustomerRequest;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $data = User::where('is_delete', 0)->where("user_type", 0)->orderBY('id','DESC')->get();
        if ($request->ajax()) {
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $alert_delete = "return confirm('Are you sure want to delete !')";
                    $btn = "<ul class='action'>";
                    if ($row->is_approved == 1) {
                        $btn = $btn . '<li class="delete"> <a   href="javascript:void(0)" href="' . route('customer.status', $row->id) . '" title="Deactivate" class="status-change" data-url="' . route('customer.status', $row->id) . '"><i class="fa fa-close"></i></a>   </li> ';
                    } else {
                        $btn = $btn . ' <li class="edit"> <a   href="javascript:void(0)" href="' . route('customer.status', $row->id) . '"   class="status-change" title="Activate" data-url="' . route('customer.status', $row->id) . '"><i class="icon-check"></i></a></li> ';
                    }

                    $btn = $btn . ' <li class="edit"> <a class="edit-data"  href="javascript:void(0)" title="Edit" data-url="' . route('customer.edit', $row->id) . '"><i class="icon-pencil-alt"></i></a></li>';
                    $btn = $btn . ' <li class="delete"><a href="" data-url="' . route('customer.destroy', $row->id) . '" class="destroy-data" title="Delete"> <i class="icon-trash"></i></a></li> ';
                    

                    // $btn = $btn . ' <li class="show"> <a class="show-data"  href="javascript:void(0)" title="show" data-url="' . route('customer.show', $row->id) . '"><i class="icon-eye"></i></a></li> </ul>';
                    $btn = $btn . ' <li class="show"> <a class="show-data"  href="' . route('customer.show', $row->id) . '" title="Show"><i class="icon-eye"></i></a></li> </ul>';
                    return $btn;
                })

                ->addColumn('user_details', function ($data) {
                    if ($data['profile_image'] == null && $data['profile_image'] == "") {
                        return ' <ul>
                        <li>
                          <div class="media"><img class="b-r-8 img-40" src=' . URL::to('/public') . '/admin/assets/images/user/user.png' . '  alt="Generic placeholder image"> <div class="media-body">
                          <div class="row">
                            <div class="col-xl-12">
                            <h6 class="mt-0">&nbsp;&nbsp; ' . $data->name . '</span></h6>
                            </div>
                          </div>
                          <p>&nbsp;&nbsp; ' . $data->email . '</p>
                        </div>
                      </div>
                    </li>
                  </ul>';
                    } else {
                        return ' <ul>
                        <li>
                          <div class="media"><img class="b-r-8 img-40" src=' . URL::to('/public') . '/profile_image/' . $data->profile_image . '  alt="Generic placeholder image">
                            <div class="media-body">
                              <div class="row">
                                <div class="col-xl-12">
                                <h6 class="mt-0">&nbsp;&nbsp; ' . $data->name . '</span></h6>
                                </div>
                              </div>
                              <p>&nbsp;&nbsp; ' . $data->email . '</p>
                            </div>
                          </div>
                        </li>
                      </ul>';
                    }
                })

                ->addColumn('is_approved', function ($data) {
                    if ($data->is_approved == 1) {
                        return '<span class="badge bg-success">Approved</span>';
                    } elseif ($data->is_approved == 2) {
                        return '<span class="badge bg-danger">Reject</span>';
                    } elseif ($data->is_approved == 3) {
                        return '<span class="badge bg-werning">Block</span>';
                    } else {
                        return '<span class="badge bg-info">Pending</span>';
                    }
                })

                ->addColumn('joing_date', function ($data) {
                    return date('Y-M-d h:i A', strtotime($data->created_at));

                })

                ->rawColumns(['action', 'is_approved', 'user_details', 'joing_date'])
                ->make(true);
        }
        return view('Admin.Customer.index');

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
        try {
            $data = User::find($id);
            $data_predefined_answer = PredefinedAnswer::where('user_id',$id)->first();
            if (!empty($data)) {
                return view('Admin.Customer.show', compact('data','data_predefined_answer'));
            }
        } catch (Exception $ex) {
            return response()->json(
                ['success' => false, 'message' => $ex->getMessage()]
            );
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        try {
            $data = User::find($id);
            if (!empty($data)) {
                return view('Admin.Customer.edit', compact('data'));
            }
        } catch (Exception $ex) {
            return response()->json(
                ['success' => false, 'message' => $ex->getMessage()]
            );
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerRequest $request, string $id)
    {
        //
        try {
            $request->user()->fill($request->validated());
            $data = User::find($id);

            // for Image
            if ($request->hasFile('profile_image')) {
                File::delete(public_path('profile_image/' . $data->profile_image));

                $source = $_FILES['profile_image']['tmp_name'];
                if($source){
                          $destinationFolder = public_path('profile_image'); // Specify the destination folder
                          $image = $request->file('profile_image');
                          $filename =  time() .'_profile_image.' . $image->getClientOriginalExtension();
                          if (!file_exists($destinationFolder)) {
                              mkdir($destinationFolder, 0777, true);
                          }
                          $destination = $destinationFolder . '/' . $filename;
                          $profile_image = compressImage($source, $destination);
                          $data->profile_image = $filename;
                 }
            }

            $data->name = $request['name'];
            $data->phone = $request['phone'];
            $data->gender = $request['gender'];
            $data->save();
            if (!empty($data)) {
                return response()->json(['status' => '1', 'success' => 'Profile edit Successfully']);
            }
        } catch (Exception $ex) {
            return response()->json(
                ['success' => false, 'message' => $ex->getMessage()]
            );
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        try {
            DB::beginTransaction();
            // User::find($id)->delete();
            $data = User::find($id);
            $data->is_delete = 1;
            $data->update();
            DB::commit(); // Commit Transaction
            return response()->json(['status' => '1', 'success' => 'Customer deleted successfully']);
        } catch (\Exception $e) {
            DB::rollBack(); //Rollback Transaction
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function customerStatus($id)
    {
        try {
            DB::beginTransaction();
            $data = User::find($id);
            if ($data->is_approved == 1) {
                $data->is_approved = 0;
                $message = "Deactived";
            } else {
                $data->is_approved = 1;
                $message = "Actived";
            }
            $data->update();
            DB::commit(); // Commit Transaction
             return response()->json(['status' => '1', 'success' => 'Customer ' . $message . ' Successfully']);
        } catch (\Exception $e) {
            DB::rollBack(); //Rollback Transaction
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

}
