<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use Illuminate\Http\Request;
use App\Models\GamificationConfig;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class GamificationConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        if ($request->ajax()) {
            $data = GamificationConfig::where('is_delete',0)->orderBY('id','DESC')->get();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $alert_delete = "return confirm('Are you sure want to delete !')";
                    $btn = "<ul class='action'>";

                    $btn = $btn .  '<li class="edit"> <a class="edit-data"  href="javascript:void(0)" title="Edit" data-url="'.route('gamification-config.edit', $row->id).'"><i class="icon-pencil-alt"></i></a></li>';
                    // $btn = $btn . ' <li class="delete"><a href="" data-url="' . route('gamification-config.destroy', $row->id) . '" class="destroy-data" title="Delete"> <i class="icon-trash"></i></a></li> ';
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

                ->addColumn('config_name', function ($data) {
                    $title_array = json_decode($data['config_name'], true);
                    if (!empty($title_array['en']['config_name'])) {$config_name = $title_array['en']['config_name'];} else { $config_name = "No Data Found";}
                    $name = $data->id;
                    return $config_name;
                })

                ->rawColumns(['action', 'status','config_name'])
                ->make(true);
        }
        return view('Admin.Gamification-Config.index');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('Admin.Gamification-Config.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        $validated = [];
        $customMessages = [];
        $validated['config_key'] = "required";
        $validated['config_value'] = "required";
        foreach (get_language() as $key => $lang) {
            $validated['config_name.' . $lang->code . '.config_name'] = "required";

            $customMessages['config_name.' . $lang->code . '.config_name.required'] = "The ". $lang->language ." Text is required.";
        }

        $request->validate($validated,$customMessages);
        try {
            $post = $request->all();
            $data = new GamificationConfig();
            $data->config_name = json_encode($request->config_name);
            $data->status = 1;
            $data->config_key = $request->config_key;
            $data->config_value = $request->config_value;
            $data->save();
            if (!empty($data)) {
                return response()->json(['status' => '1', 'success' => 'Config Added Successfully.']);
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
        //
        try {
            $data = GamificationConfig::find($id);
            if (!empty($data)) {
                return view('Admin.Gamification-Config.edit', compact('data'));
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
        $validated['config_key'] = "required";
        $validated['config_value'] = "required";
        foreach (get_language() as $key => $lang) {
            $validated['config_name.' . $lang->code . '.config_name'] = "required";

            $customMessages['config_name.' . $lang->code . '.config_name.required'] = "The ". $lang->language ." Text is required.";
        }
        $request->validate($validated,$customMessages);

        try {
            $data = GamificationConfig::find($id);
            $data->config_name = json_encode($request->config_name);
            $data->config_key = $request->config_key;
            $data->config_value = $request->config_value;
            $data->update();
            if (!empty($data)) {
                    return response()->json(['status' => '1', 'success' => 'Config Updated successfully.']);
                }
        } catch (Exception $ex) {
            return response()->json(
                ['success' => false, 'message' => $ex->getMessage()]
            );
        }

    }




}
