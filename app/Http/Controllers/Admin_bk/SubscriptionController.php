<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use App\Models\Categories;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        if ($request->ajax()) {
            $data = Subscription::where('is_delete', 0)->orderBY('id','DESC')->get();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $alert_delete = "return confirm('Are you sure want to delete !')";
                    $btn = "<ul class='action'>";
                    if ($row->status == 1) {
                        $btn = $btn . '<li class="delete"> <a   href="javascript:void(0)" href="' . route('subscription.status', $row->id) . '" title="Deactivate" class="status-change" data-url="' . route('subscription.status', $row->id) . '"><i class="fa fa-close"></i></a>  </li> ';
                    } else {
                        $btn = $btn . ' <li class="edit"> <a   href="javascript:void(0)" href="' . route('subscription.status', $row->id) . '"   class="status-change" title="Activate" data-url="' . route('subscription.status', $row->id) . '"><i class="icon-check"></i></a></li> ';
                    }
                    $btn = $btn . '<li class="edit"> <a class="edit-data"  href="javascript:void(0)" title="Edit" data-url="' . route('subscription.edit', $row->id) . '"><i class="icon-pencil-alt"></i></a></li>';

                    $btn = $btn . ' <li class="delete"><a href="" data-url="' . route('subscription.destroy', $row->id) . '" class="destroy-data" title="Delete"> <i class="icon-trash"></i></a></li> </ul>';
                    return $btn;

                })
                ->addColumn('name', function ($data) {
                    $title_array = json_decode($data['name'], true);
                    if (!empty($title_array['en']['subscription_name'])) {$data_blog_title = $title_array['en']['subscription_name'];} else { $data_blog_title = "No Data Found";}
                    $name = $data->id;
                    return $data_blog_title;
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
                ->rawColumns(['action', 'status', 'id'])
                ->make(true);
        }
        return view('Admin.Subscription.index');
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
        $validated['key'] = "required";
        $validated['duration'] = "required|numeric";
        $validated['amount'] = "required|numeric";
        $validated['subscription_type'] = "required";
        $validated['featured'] = "required";
        $validated['category_id'] = "required_if:subscription_type,categories_wise";
        foreach (get_language() as $key => $lang) {
            $validated['subscription_name.' . $lang->code . '.subscription_name'] = "required";
            $validated['subscription_description.' . $lang->code . '.subscription_description'] = "required";

            $customMessages['subscription_name.' . $lang->code . '.subscription_name.required'] = "The ". $lang->language ." Subscription Name is required.";
            $customMessages['subscription_description.' . $lang->code . '.subscription_description.required'] = "The ". $lang->language ." Subscription Description is required.";
        }

        $request->validate($validated,$customMessages);

        try {

            $post = $request->all();
            $data = new Subscription();
            $data->key = $request->key;
            $data->featured = $request->featured;
            $data->duration = $request->duration;
            $data->amount = $request->amount;
            $data->subscription_type = $request->subscription_type;
            if($request->subscription_type  == "whole_system")
            {
                $data->category_id =  null;
            }
            else
            {

                $data->main_category_id = $request->category_id;
                $category_array = []; // Initialize an empty array
                foreach($request->category_id as $category) {
                    $data_category_ids = Categories::where('parent_id', $category)->get();
                    foreach($data_category_ids as $subcategory) {
                        if (!in_array($subcategory->id, $category_array)) {
                            $category_array[] = $subcategory->id; // Add the subcategory ID to the array
                        }
                    }
                }
                // Convert numeric IDs to string IDs
             // Convert numeric IDs to string IDs
            $string_category_array = array_map('strval', $category_array);

            // Convert $request->category_id to an array of strings if needed
            $request_category_ids = array_map('strval', (array)$request->category_id);

            // Combine arrays and remove duplicates
            $combined_array = array_unique(array_merge($string_category_array, $request_category_ids));

            // Dump and die to inspect the resulting array
            $data->category_id = $combined_array;

            }

            $data->name = json_encode($request->subscription_name);
            $data->description = json_encode($request->subscription_description);
            $data->status = 1;
            $data->save();
            if (!empty($data)) {
                return response()->json(['status' => '1', 'success' => 'Subscription added successfully.']);
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
            $data = Subscription::find($id);
            if (!empty($data)) {
                return view('Admin.Subscription.edit', compact('data'));
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

        $customMessages = [];
        $validated = [];
        $validated['key'] = "required";
        $validated['duration'] = "required|numeric";
        $validated['amount'] = "required|numeric";
        $validated['subscription_type'] = "required";
        $validated['featured'] = "required";
        $validated['category_id'] = "required_if:subscription_type,categories_wise";
        foreach (get_language() as $key => $lang) {
            $validated['subscription_name.' . $lang->code . '.subscription_name'] = "required";
            $validated['subscription_description.' . $lang->code . '.subscription_description'] = "required";

            $customMessages['subscription_name.' . $lang->code . '.subscription_name.required'] = "The ". $lang->language ." Subscription Name is required.";
            $customMessages['subscription_description.' . $lang->code . '.subscription_description.required'] = "The ". $lang->language ." Subscription Description is required.";
        }
        $request->validate($validated,$customMessages);

        try {
            $data = Subscription::find($id);
            $data->key = $request->key;
            $data->featured = $request->featured;
            $data->duration = $request->duration;
            $data->amount = $request->amount;
            if($request->subscription_type  == "whole_system")
            {
                $data->category_id =  null;
            }
            else
            {
                $data->main_category_id = $request->category_id;
                    $category_array = []; // Initialize an empty array
                    foreach($request->category_id as $category) {
                        $data_category_ids = Categories::where('parent_id', $category)->get();
                        foreach($data_category_ids as $subcategory) {
                            if (!in_array($subcategory->id, $category_array)) {
                                $category_array[] = $subcategory->id; // Add the subcategory ID to the array
                            }
                        }
                    }
                    // Convert numeric IDs to string IDs
                // Convert numeric IDs to string IDs
                $string_category_array = array_map('strval', $category_array);

                // Convert $request->category_id to an array of strings if needed
                $request_category_ids = array_map('strval', (array)$request->category_id);

                // Combine arrays and remove duplicates
                $combined_array = array_unique(array_merge($string_category_array, $request_category_ids));

                // Dump and die to inspect the resulting array
                $data->category_id = $combined_array;

            }
            $data->subscription_type = $request->subscription_type;
            $data->name = json_encode($request->subscription_name);
            $data->description = json_encode($request->subscription_description);
            $data->status = 1;
            $data->update();
            if (!empty($data)) {
                    return response()->json(['status' => '1', 'success' => 'Subscription Updated successfully.']);
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
         //
         try {
            DB::beginTransaction();
            $data = Subscription::find($id);
            $data->is_delete = 1;
            $data->update();
            DB::commit(); // Commit Transaction
            return response()->json(['status' => '1', 'success' => 'Subscription deleted successfully']);
        } catch (\Exception $e) {
            DB::rollBack(); //Rollback Transaction
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function subscriptionStatus($id)
    {
        try {
            DB::beginTransaction();
            $data = Subscription::find($id);
            if ($data->status == 1) {
                $data->status = 0;
                $message = "Deactived";
            } else {
                $data->status = 1;
                $message = "Actived";
            }
            $data->update();
            DB::commit(); // Commit Transaction
            return response()->json(['status' => '1', 'success' => 'Subscription ' . $message . ' Successfully']);
        } catch (\Exception $e) {
            DB::rollBack(); //Rollback Transaction
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

}
