<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use File;
use App\Models\Badge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BadgeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        if ($request->ajax()) {
            $data = Badge::where('is_delete',0)->orderBY('id','DESC')->get();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $alert_delete = "return confirm('Are you sure want to delete !')";
                    $btn = "<ul class='action'>";
                    if ($row->status == 1) {
                        $btn = $btn . '<li class="delete"> <a   href="javascript:void(0)" href="' . route('badge.status', $row->id) . '" title="Deactivate" class="status-change" data-url="' . route('badge.status', $row->id) . '"><i class="fa fa-close"></i></a>  &nbsp; </li> ';
                    } else {
                        $btn = $btn . ' <li class="edit"> <a   href="javascript:void(0)" href="' . route('badge.status', $row->id) . '"   class="status-change" title="Activate" data-url="' . route('badge.status', $row->id) . '"><i class="icon-check"></i></a></li> ';
                    }

                    $btn = $btn .  '<li class="edit"> <a class="edit-data"  href="javascript:void(0)" title="Edit" data-url="'.route('badge.edit', $row->id).'"><i class="icon-pencil-alt"></i></a></li>';
                    $btn = $btn . ' <li class="delete"><a href="" data-url="' . route('badge.destroy', $row->id) . '" class="destroy-data" title="Delete"> <i class="icon-trash"></i></a></li> ';
                    $btn = $btn . '</ul>';
                    return $btn;

                })


                ->addColumn('id', function ($data) {
                    $name = $data->id;
                    return $name;
                })

                ->addColumn('status', function ($data) {
                    if ($data->status == 1) {
                        return '<span class="badge bg-success">Active</span>';
                    } else {
                        return '<span class="badge bg-danger">In-Active</span>';
                    }
                })

                ->addColumn('badge_name', function ($data) {
                    $title_array = json_decode($data['badge_name'], true);
                    if (!empty($title_array['en']['badge_name'])) {$badge_name = $title_array['en']['badge_name'];} else { $badge_name = "No Data Found";}
                    $name = $data->id;
                    return $badge_name;
                })

                ->rawColumns(['action', 'status','badge_name'])
                ->make(true);
        }
        return view('Admin.Badges.index');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('Admin.Badges.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        $validated = [];
        $customMessages = [];
        $validated['badge_image'] = "required";
        $validated['badge_required_minute'] = "required|numeric";
        $validated['badge_required_number_refer'] = "required|numeric";
        $validated['badge_required_challenge'] = "required|numeric";
        foreach (get_language() as $key => $lang) {
            $validated['badge_name.' . $lang->code . '.badge_name'] = "required";

            $customMessages['badge_name.' . $lang->code . '.badge_name.required'] = "The ". $lang->language ." Badge Name is required.";
        }

        $request->validate($validated,$customMessages);
        try {
            $post = $request->all();
            $data = new Badge();


            //for image
            if ($request->hasFile('badge_image')) {

                $source = $_FILES['badge_image']['tmp_name'];
                if($source){
                          $destinationFolder = public_path('badge_image'); // Specify the destination folder
                          $image = $request->file('badge_image');
                          $filename =  time() .'_badge_image.' . $image->getClientOriginalExtension();
                          if (!file_exists($destinationFolder)) {
                              mkdir($destinationFolder, 0777, true);
                          }
                          $destination = $destinationFolder . '/' . $filename;
                          $badge_image = compressImage($source, $destination);
                          $data->badge_image = $filename;
                 }

            }

            $data->badge_name = json_encode($request->badge_name);
            $data->badge_required_minute = $request->badge_required_minute;
            $data->badge_required_number_refer = $request->badge_required_number_refer;
            $data->badge_required_challenge = $request->badge_required_challenge;
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
        //
        try {
            $data = Badge::find($id);
            if (!empty($data)) {
                return view('Admin.Badges.edit', compact('data'));
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
        $customMessages = [];
        $validated['badge_required_minute'] = "required|numeric";
        $validated['badge_required_number_refer'] = "required|numeric";
        $validated['badge_required_challenge'] = "required|numeric";
        foreach (get_language() as $key => $lang) {
            $validated['badge_name.' . $lang->code . '.badge_name'] = "required";

            $customMessages['badge_name.' . $lang->code . '.badge_name.required'] = "The ". $lang->language ." Text is required.";
        }
        $request->validate($validated,$customMessages);

        try {
            $data = Badge::find($id);


             //for image
             if ($request->hasFile('badge_image')) {
                File::delete(public_path('badge_image/' . $data->badge_image));

                $source = $_FILES['badge_image']['tmp_name'];
                if($source){
                          $destinationFolder = public_path('badge_image'); // Specify the destination folder
                          $image = $request->file('badge_image');
                          $filename =  time() .'_badge_image.' . $image->getClientOriginalExtension();
                          if (!file_exists($destinationFolder)) {
                              mkdir($destinationFolder, 0777, true);
                          }
                          $destination = $destinationFolder . '/' . $filename;
                          $badge_image = compressImage($source, $destination);
                          $data->badge_image = $filename;
                 }

            }


            $data->badge_name = json_encode($request->badge_name);
            $data->badge_required_minute = $request->badge_required_minute;
            $data->badge_required_number_refer = $request->badge_required_number_refer;
            $data->badge_required_challenge = $request->badge_required_challenge;
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
            $data = Badge::find($id);
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

    public function badgeStatus($id)
    {
        try {
            DB::beginTransaction();
            $data = Badge::find($id);
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
