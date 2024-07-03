<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MultiLanguage;
use DataTables;
use Illuminate\Support\Facades\DB;


class MultiLanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
         if ($request->ajax()) {
            $data = MultiLanguage::where('is_delete',0)->orderBy('id',"DESC")->orderBY('id','DESC')->get();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $alert_delete = "return confirm('Are you sure want to delete !')";
                    $btn = "<ul class='action'>";
                    if ($row->status == 1) {
                        $btn = $btn . '<li class="delete"> <a   href="javascript:void(0)" href="' . route('multi-language-status', $row->id) . '" title="Deactivate" class="status-change" data-url="' . route('multi-language-status', $row->id) . '"><i class="fa fa-close"></i></a>  </li> ';
                    } else {
                        $btn = $btn . ' <li class="edit"> <a   href="javascript:void(0)" href="' . route('multi-language-status', $row->id) . '"   class="status-change" title="Activate" data-url="' . route('multi-language-status', $row->id) . '"><i class="icon-check"></i></a></li> ';
                    }
                    $btn = $btn .  '<li class="edit"> <a class="edit-data"  href="javascript:void(0)" title="Edit" data-url="'.route('multi-language.edit', $row->id).'"><i class="icon-pencil-alt"></i></a></li>';
                    $btn = $btn . ' <li class="delete"><a href="" data-url="' . route('multi-language.destroy', $row->id) . '" class="destroy-data" title="Delete"> <i class="icon-trash"></i></a></li> </ul>';
                    return $btn;
                })


                ->addColumn('status', function ($data) {
                    if ($data->status == 1) {
                        return '<span class="badge bg-success">Active</span>';
                    } else {
                        return '<span class="badge bg-danger">In-Active</span>';
                    }
                })
                ->rawColumns(['action', 'status', 'code', 'language'])
                ->make(true);
        }
        return view('Admin.Multi-Language.index');

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
        $validated['key'] = "required|unique:multi_languages,key";
        foreach (get_language() as $key => $lang) {
            $validated['content.' . $lang->code . '.content'] = "required";

            $customMessages['content.' . $lang->code . '.content.required'] = "The ". $lang->language ." Content is required.";
        }

        $request->validate($validated,$customMessages);

        try {
            $post = $request->all();
            $data = new MultiLanguage();
            $data->key = $request->key;
            $data->content = json_encode($request->content);
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
            $data = MultiLanguage::find($id);
            if (!empty($data)) {
                return view('Admin.Multi-Language.edit', compact('data'));
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
        foreach (get_language() as $key => $lang) {
            $validated['content.' . $lang->code . '.content'] = "required";

            $customMessages['content.' . $lang->code . '.content.required'] = "The ". $lang->language ." Content is required.";
        }
        $request->validate($validated,$customMessages);

        try {
            $data = MultiLanguage::find($id);
            $data->content = json_encode($request->content);
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
             $data = MultiLanguage::find($id);
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


    public function multilanguageStatus($id)
    {
        try {
            DB::beginTransaction();
            $data = MultiLanguage::find($id);
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
