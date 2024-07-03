<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SubAdminRequest;
use App\Models\User;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Mail;
use URL;

class SubAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $data = User::where('is_delete', 0)->where("user_type", 1)->orderBY('id','DESC')->get();
        if ($request->ajax()) {
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $alert_delete = "return confirm('Are you sure want to delete !')";
                    $btn = "<ul class='action'>";
                    if ($row->is_approved == 1) {
                        $btn = $btn . '<li class="delete"> <a   href="javascript:void(0)" href="' . route('subadmin.status', $row->id) . '" title="Deactivate" class="status-change" data-url="' . route('subadmin.status', $row->id) . '"><i class="fa fa-close"></i></a>   </li> ';
                    } else {
                        $btn = $btn . ' <li class="edit"> <a   href="javascript:void(0)" href="' . route('subadmin.status', $row->id) . '"   class="status-change" title="Activate" data-url="' . route('subadmin.status', $row->id) . '"><i class="icon-check"></i></a></li> ';
                    }

                    $btn = $btn . ' <li class="edit"> <a class="edit-data"  href="javascript:void(0)" title="Edit" data-url="' . route('subadmin.edit', $row->id) . '"><i class="icon-pencil-alt"></i></a></li>';
                    $btn = $btn . ' <li class="delete"><a href="" data-url="' . route('subadmin.destroy', $row->id) . '" class="destroy-data" title="Delete"> <i class="icon-trash"></i></a></li> ';
                    $btn = $btn . ' <li class="show"> <a class="show-data"  href="javascript:void(0)" title="Show" data-url="' . route('subadmin.show', $row->id) . '"><i class="icon-eye"></i></a></li> </ul>';
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
                        return '<span class="badge bg-info">Pendding</span>';
                    }
                })

                ->addColumn('joing_date', function ($data) {
                    return date('Y-M-d h:i A', strtotime($data->created_at));

                })

                ->rawColumns(['action', 'is_approved', 'user_details', 'joing_date'])
                ->make(true);
        }
        return view('Admin.Sub-Admin.index');

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
        $validated = [];
        $validated['email'] = "required|email|unique:users";
        $validated['name'] = "required|string|min:3|max:32";
        $validated['phone'] = "required|digits_between:8,12|numeric";
        $validated['gender'] = "required";
        $validated['role_name'] = "required";
        $validated['password'] = "required";
        $validated['profile_image'] = "mimes:jpg,png,jpeg";
        $validated['admin_commission'] = "required|numeric";
        $request->validate($validated);

        try {
            $email = $request['email'];
            $password = $request['password'];
            $post = $request->all();
            $data = new User();
            $data->name = $request['name'];
            $data->phone = $request['phone'];
            $data->gender = $request['gender'];
            $data->email = $request['email'];
            $data->role_name = $request['role_name'];
            $data->admin_commission = $request['admin_commission'];
            $data->password = Hash::make($request->password);

            //set defeult
            $data->user_type = 1;
            $data->is_approved = 1;
            $data->status = 0;

            $data->height = 0;
            $data->weight = 0;
            $data->age = 0;
            //set defeult

            if ($request->hasFile('profile_image')) {

                $source = $_FILES['profile_image']['tmp_name'];
                if ($source) {
                    $destinationFolder = public_path('profile_image'); // Specify the destination folder
                    $image = $request->file('profile_image');
                    $filename = time() . '_profile_image.' . $image->getClientOriginalExtension();
                    if (!file_exists($destinationFolder)) {
                        mkdir($destinationFolder, 0777, true);
                    }
                    $destination = $destinationFolder . '/' . $filename;
                    $profile_image = compressImage($source, $destination);
                    $data->profile_image = $filename;
                }

            }

            $data->save();
            if (!empty($data)) {

               $email =  $data->email;
                Mail::send(
                    ['html' => 'email.subadmin_register'],
                    array(
                        'email' => $email,
                        'password' => $password,
                    ),
                    function ($message) use ($email) {
                        $message->from(env('MAIL_USERNAME'), 'Zensoma');
                        $message->to($email);
                        $message->subject("Welcome to Zensoma as Subadmin...");
                    }
                );
                return response()->json(['status' => '1', 'success' => 'Data Added Successfully.']);
                //
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
        try {
            $data = User::find($id);
            if (!empty($data)) {
                return view('Admin.Sub-Admin.show', compact('data'));
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
        //edit subadmin details
        try {
            $data = User::find($id);
            if (!empty($data)) {
                return view('Admin.Sub-Admin.edit', compact('data'));
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
    public function update(Request $request, string $id)
    {
        //

        $validated = [];
        $validated['email'] = 'required|email|unique:users,email,' . $id;
        $validated['name'] = "required|string|min:3|max:32";
        $validated['phone'] = "required|digits_between:8,12|numeric";
        $validated['gender'] = "required";
        $validated['role_name'] = "required";
        $validated['admin_commission'] = "required|numeric";
        if ($request->hasFile('profile_image')) {
            $validated['profile_image'] = "mimes:jpg,png,jpeg";
        }
        $request->validate($validated);

        try {
            $post = $request->all();
            $data = User::find($id);
            $data->name = $request['name'];
            $data->phone = $request['phone'];
            $data->gender = $request['gender'];
            $data->email = $request['email'];
            $data->role_name = $request['role_name'];
            $data->admin_commission = $request['admin_commission'];
            $data->user_type = 1;
            $data->is_approved = 1;
            $data->status = 0;
            if ($request->hasFile('profile_image')) {
                File::delete(public_path('profile_image/' . $data->icon));

                $source = $_FILES['profile_image']['tmp_name'];
                if ($source) {
                    $destinationFolder = public_path('profile_image'); // Specify the destination folder
                    $image = $request->file('profile_image');
                    $filename = time() . '_profile_image.' . $image->getClientOriginalExtension();
                    if (!file_exists($destinationFolder)) {
                        mkdir($destinationFolder, 0777, true);
                    }
                    $destination = $destinationFolder . '/' . $filename;
                    $profile_image = compressImage($source, $destination);
                    $data->profile_image = $filename;
                }
            }

            $data->save();
            if (!empty($data)) {
                return response()->json(['status' => '1', 'success' => 'Data Updated Successfully.']);
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
            $data = User::find($id);
            $data->is_delete = 1;
            $data->update();
            DB::commit(); // Commit Transaction
            return response()->json(['status' => '1', 'success' => 'Data Deleted Successfully.']);
        } catch (\Exception $e) {
            DB::rollBack(); //Rollback Transaction
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function subadminStatus($id)
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
            return response()->json(['status' => '1', 'success' => 'Data ' . $message . ' Successfully']);
        } catch (\Exception $e) {
            DB::rollBack(); //Rollback Transaction
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
