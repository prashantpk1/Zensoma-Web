<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LanguageRequest;
use App\Models\Language;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = Language::where('is_delete',0)->orderBY('id','DESC')->get();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $alert_delete = "return confirm('Are you sure want to delete !')";
                    $btn = "<ul class='action'>";
                    if ($row->status == 1) {
                        $btn = $btn . '<li class="delete"> <a   href="javascript:void(0)" href="' . route('language.status', $row->id) . '" title="Deactivate" class="status-change" data-url="' . route('language.status', $row->id) . '"><i class="fa fa-close"></i></a>  </li> ';
                    } else {
                        $btn = $btn . ' <li class="edit"> <a   href="javascript:void(0)" href="' . route('language.status', $row->id) . '"   class="status-change" title="Activate" data-url="' . route('language.status', $row->id) . '"><i class="icon-check"></i></a></li> ';
                    }

                    $btn = $btn .  '<li class="edit"> <a class="edit-data"  href="javascript:void(0)" title="Edit" data-url="'.route('language.edit', $row->id).'"><i class="icon-pencil-alt"></i></a></li>';
                    $btn = $btn . ' <li class="delete"><a href="" data-url="' . route('language.destroy', $row->id) . '" class="destroy-data" title="Delete"> <i class="icon-trash"></i></a></li>';

                    $btn = $btn . ' </ul>';
                    return $btn;
                })
                ->addColumn('code', function ($data) {
                    $name = $data->code;
                    return $name;
                })

                ->addColumn('language', function ($data) {
                    $name = $data->language;
                    return $name;
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
        return view('Admin.Language.index');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('Admin.Language.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LanguageRequest $request)
    {

        try {
            $post = $request->all();
            $data = new Language();
            $lowercaseString = strtolower($request->language_code);
            $data->code = str_replace(' ', '_', $lowercaseString);
            $data->language = $request->language_name;
            $data->status = 1;
            $data->save();
            if (!empty($data)) {
                return response()->json(['status' => '1', 'success' => 'Data Updated successfully.']);
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
        // $data = language::find($id);
        // return view('Admin.Language.edit', compact('data'));



        try {
            $data = Language::find($id);
            if (!empty($data)) {
                return view('Admin.Language.edit', compact('data'));
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
    public function update(LanguageRequest $request, string $id)
    {
        //
        try {
            $data = Language::find($id);
            $lowercaseString = strtolower($request->language_code);
            $data->code = str_replace(' ', '_', $lowercaseString);
            $data->language = $request->language_name;
            $data->update();
            if (!empty($data)) {
            return response()->json(['status' => '1', 'success' => 'Data Updated successfully.']);
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
            // language::find($id)->delete();
            $data = Language::find($id);
            $data->is_delete = 1;
            $data->update();
            DB::commit(); // Commit Transaction
            return response()->json(['status' => '1', 'success' => 'Language deleted successfully']);
        } catch (\Exception $e) {
            DB::rollBack(); //Rollback Transaction
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function languageStatus($id)
    {
        try {
            DB::beginTransaction();
            $data = Language::find($id);
            if ($data->status == 1) {
                $data->status = 0;
                $message = "Deactived";
            } else {
                $data->status = 1;
                $message = "Actived";
            }
            $data->update();
            DB::commit(); // Commit Transaction
            return response()->json(['status' => '1', 'success' => 'Language ' . $message . ' Successfully']);
        } catch (\Exception $e) {
            DB::rollBack(); //Rollback Transaction
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
