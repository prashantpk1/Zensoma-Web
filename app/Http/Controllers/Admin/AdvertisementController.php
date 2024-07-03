<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use File;
use Illuminate\Http\Request;
use App\Models\Advertisement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\advertisementRequest;

class AdvertisementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = Advertisement::where('is_delete',0)->orderBY('id','DESC')->get();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $alert_delete = "return confirm('Are you sure want to delete !')";
                    $btn = "<ul class='action'>";
                    if ($row->status == 1) {
                        $btn = $btn . '<li class="delete"> <a   href="javascript:void(0)" href="' . route('advertisement.status', $row->id) . '" title="Deactivate" class="status-change" data-url="' . route('advertisement.status', $row->id) . '"><i class="fa fa-close"></i></a>  </li> ';
                    } else {
                        $btn = $btn . ' <li class="edit"> <a   href="javascript:void(0)" href="' . route('advertisement.status', $row->id) . '"   class="status-change" title="Activate" data-url="' . route('advertisement.status', $row->id) . '"><i class="icon-check"></i></a></li> ';
                    }

                    $btn = $btn .  '<li class="edit"> <a class="edit-data"  href="javascript:void(0)" title="Edit" data-url="'.route('advertisement.edit', $row->id).'"><i class="icon-pencil-alt"></i></a></li>';
                    $btn = $btn . ' <li class="delete"><a href="" data-url="' . route('advertisement.destroy', $row->id) . '" class="destroy-data" title="Delete"> <i class="icon-trash"></i></a></li> ';
                    $btn = $btn . ' </ul>';
                    return $btn;
                })

                ->addColumn('image', function ($data) {
                    if ($row['blog_image'] = null) {
                        return '<span class="badge badge-soft-success fs-12">no image</span>';
                    } else {
                        return '<img src=' . URL::to('/public') . '/advertisement_image/' . $data->advertisement_image . ' class="img-thumbnail" width="50" height="55"/>';
                    }
                })


                ->addColumn('status', function ($data) {
                    if ($data->status == 1) {
                        return '<span class="badge bg-success">Active</span>';
                    } else {
                        return '<span class="badge bg-danger">In-Active</span>';
                    }
                })
                ->rawColumns(['action', 'status','image'])
                ->make(true);
        }
        return view('Admin.Advertisement.index');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('Admin.Advertisement.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {



        $validated = [];
        $validated['advertisement_image'] = "required|mimes:jpg,png,jpeg";
        $request->validate($validated);

        try {
            $post = $request->all();
            $data = new Advertisement();
            $uploaded = '';

            //for image
            if ($request->hasFile('advertisement_image')) {

                $source = $_FILES['advertisement_image']['tmp_name'];
                if($source){
                          $destinationFolder = public_path('advertisement_image'); // Specify the destination folder
                          $image = $request->file('advertisement_image');
                          $filename =  time() .'_advertisement_image.' . $image->getClientOriginalExtension();
                          if (!file_exists($destinationFolder)) {
                              mkdir($destinationFolder, 0777, true);
                          }
                          $destination = $destinationFolder . '/' . $filename;
                          $advertisement_image = compressImage($source, $destination);
                          $data->advertisement_image = $filename;
                 }

            }


            $data->status = 1;
            $data->save();
            if (!empty($data)) {
                return response()->json(['status' => '1', 'success' => 'Data Added Successfully.']);
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
        try {
            $data = Advertisement::find($id);
            if (!empty($data)) {
                return view('Admin.Advertisement.edit', compact('data'));
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
        $validated['advertisement_image'] = "required|mimes:jpg,png,jpeg";
        $request->validate($validated);

        try {
            $data = Advertisement::find($id);
            //for image
            if ($request->hasFile('advertisement_image')) {
                File::delete(public_path('advertisement_image/' . $data->advertisement_image));

                $source = $_FILES['advertisement_image']['tmp_name'];
                if($source){
                          $destinationFolder = public_path('advertisement_image'); // Specify the destination folder
                          $image = $request->file('advertisement_image');
                          $filename =  time() .'_advertisement_image.' . $image->getClientOriginalExtension();
                          if (!file_exists($destinationFolder)) {
                              mkdir($destinationFolder, 0777, true);
                          }
                          $destination = $destinationFolder . '/' . $filename;
                          $advertisement_image = compressImage($source, $destination);
                          $data->advertisement_image = $filename;
                 }

            }
            $data->update();
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
            $data = advertisement::find($id);
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

    public function advertisementStatus($id)
    {
        try {
            DB::beginTransaction();
            $data = Advertisement::find($id);
            if ($data->status == 1) {
                $data->status = 0;
                $message = "Deactived";
            } else {
                $data->status = 1;
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
