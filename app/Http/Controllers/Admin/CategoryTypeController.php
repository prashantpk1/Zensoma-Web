<?php

namespace App\Http\Controllers\Admin;

use File;
use DataTables;
use App\Models\CategoryType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CategoryTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //

        if ($request->ajax()) {
            $data = CategoryType::where('is_delete',0)->orderBY('id','DESC')->get();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $alert_delete = "return confirm('Are you sure want to delete !')";
                    $btn = "<ul class='action'>";
                    if ($row->status == 1) {
                        $btn = $btn . '<li class="delete"> <a   href="javascript:void(0)" href="' . route('category-type.status', $row->id) . '" title="Deactivate" class="status-change" data-url="' . route('category-type.status', $row->id) . '"><i class="fa fa-close"></i></a>   </li> ';
                    } else {
                        $btn = $btn . ' <li class="edit"> <a   href="javascript:void(0)" href="' . route('category-type.status', $row->id) . '"   class="status-change" title="Activate" data-url="' . route('category-type.status', $row->id) . '"><i class="icon-check"></i></a></li> ';
                    }


                    $btn = $btn .  '<li class="edit"> <a class="edit-data"  href="javascript:void(0)" title="Edit" data-url="'.route('category-type.edit', $row->id).'"><i class="icon-pencil-alt"></i></a></li>';
                    $btn = $btn . ' <li class="delete"><a href="" data-url="' . route('category-type.destroy', $row->id) . '" class="destroy-data" title="Delete"> <i class="icon-trash"></i></a></li> ';
                    $btn = $btn. '</ul>';
                    return $btn;
                })

                ->addColumn('status', function ($data) {
                    if ($data->status == 1) {
                        return '<span class="badge bg-success">Active</span>';
                    } else {
                        return '<span class="badge bg-danger">In-Active</span>';
                    }
                })

                ->addColumn('type_name', function ($data) {
                    $type_array = json_decode($data['type'], true);
                    if (!empty($type_array['en']['type'])) {$name = $type_array['en']['type'];} else { $name = "No Data Found";}
                    return $name;
                })

                ->rawColumns(['action', 'status','type_name'])
                ->make(true);
        }
        return view('Admin.Category-Type.index');

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
        $customMessages = [];
        $validated['main_category_id'] = "required";
        $validated['category_id'] = "required";
        foreach (get_language() as $key => $lang) {
            $validated['type.' . $lang->code . '.type'] = "required";

            $customMessages['type.' . $lang->code . '.type.required'] = "The ". $lang->language ." Category Type is required.";
        }

        $request->validate($validated,$customMessages);


        try {
            $post = $request->all();
            $data = new CategoryType();
            $data->main_category_id = json_encode($request->main_category_id);
            $data->category_id = $request->category_id;
            $data->type = json_encode($request->type);
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
            $data = CategoryType::find($id);
            if (!empty($data)) {
                return view('Admin.Category-Type.edit', compact('data'));
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
        $validated['category_id'] = "required";
        $validated['main_category_id'] = "required";
        foreach (get_language() as $key => $lang) {
            $validated['type.' . $lang->code . '.type'] = "required";
            $customMessages['type.' . $lang->code . '.type.required'] = "The ". $lang->language ." Category Type is required.";
        }
        $request->validate($validated,$customMessages);

        try {

            $data = CategoryType::find($id);
            $data->category_id = $request->category_id;
            $data->main_category_id = $request->main_category_id;
            $data->type = $request->type;
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
            $data =  CategoryType::find($id);
            $data->is_delete  = 1;
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


    public function categoryTypeStatus($id)
    {
        try {
            DB::beginTransaction();
            $data = CategoryType::find($id);
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


    public function getType(Request $request)
    {
        $types = CategoryType::whereIn('category_id', $request->category)->get();
        foreach($types as  $type)
        {
            $type_array = json_decode($type['type'], true);
            if (!empty($type_array['en']['type'])) {$type_name = $type_array['en']['type'];} else { $type_name = "No Data Found";}
            $type['type_name_en'] = $type_name;
        }
        return $types;

    }

}
