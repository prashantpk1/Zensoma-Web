<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories;
use DataTables;
use File;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        if ($request->ajax()) {
            $data = Categories::where('is_delete',0)->orderBY('id','DESC')->get();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = "<ul class='action'>";
                    if ($row->status == 1) {
                        $btn = $btn . '<li class="delete"> <a   href="javascript:void(0)" href="' . route('category.status', $row->id) . '" title="Deactivate" class="status-change" data-url="' . route('category.status', $row->id) . '"><i class="fa fa-close"></i></a>   </li> ';
                    } else {
                        $btn = $btn . ' <li class="edit"> <a   href="javascript:void(0)" href="' . route('category.status', $row->id) . '"   class="status-change" title="Activate" data-url="' . route('category.status', $row->id) . '"><i class="icon-check"></i></a></li> ';
                    }

                   
                    $btn = $btn .  '<li class="edit"> <a class="edit-data"  href="javascript:void(0)" title="Edit" data-url="'.route('category.edit', $row->id).'"><i class="icon-pencil-alt"></i></a></li>';
                    $btn = $btn . ' <li class="delete"><a href="javascript:void(0)" data-url="' . route('category.destroy', $row->id) . '" class="destroy-data" title="Delete"> <i class="icon-trash"></i></a></li> ';
                   

                    $btn = $btn . '</ul>';
                    return $btn;

                })
                ->addColumn('category_name', function ($data) {
                    $title_array = json_decode($data['category_name'], true);
                    if (!empty($title_array['en']['category_name'])) {$data_blog_title = $title_array['en']['category_name'];} else { $data_blog_title = "No Data Found";}
                    $name = $data->id;
                    return $data_blog_title;
                })

                ->addColumn('id', function ($data) {
                    $name = $data->id;
                    return $name;
                })


                ->addColumn('categories_type', function ($data) {
                    if($data->parent_id == 0)
                    {
                         $type = "Main Categories";
                    }
                    else
                    {
                        $type = "Sub Categories";
                    }
                    return $type;
                })

                ->addColumn('status', function ($data) {
                    if ($data->status == 1) {
                        return '<span class="badge bg-success">Active</span>';
                    } else {
                        return '<span class="badge bg-danger">In-Active</span>';
                    }
                })
                ->rawColumns(['action', 'status', 'categories_type'])
                ->make(true);
        }
        return view('Admin.Categories.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
        //
        // return view('Admin.Categories.create',comapct('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        $validated = [];
        $customMessages = [];
        $validated['parent_id']  = "required";
        $validated['icon']  = "required|mimes:jpg,png,jpeg";
        $validated['category_image']  = "required|mimes:jpg,png,jpeg";
        foreach (get_language() as $key => $lang) {
            $validated['category_name.' . $lang->code . '.category_name'] = "required";
            $customMessages['category_name.' . $lang->code . '.category_name.required'] = "The ". $lang->language ." Category Name is required.";

        }

        $request->validate($validated,$customMessages);

        try {
            $post = $request->all();
            $data = new Categories();
            $data->category_name = json_encode($request->category_name);
            $data->status = 1;
            $data->parent_id = $request->parent_id;

            if ($request->hasFile('icon')) {
                $image = $request->file('icon');
                $uploaded = time() . '_icon.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/icon');
                $image->move($destinationPath, $uploaded);
                $data->icon = $uploaded;

            }

            if ($request->hasFile('category_image')) {


                $source = $_FILES['category_image']['tmp_name'];
                if($source){
                          $destinationFolder = public_path('category_image'); // Specify the destination folder
                          $image = $request->file('category_image');
                          $filename =  time() .'_category_image.' . $image->getClientOriginalExtension();
                          if (!file_exists($destinationFolder)) {
                              mkdir($destinationFolder, 0777, true);
                          }
                          $destination = $destinationFolder . '/' . $filename;
                          $category_image = compressImage($source, $destination);
                          $data->category_image = $filename;
                 }

            }

            $data->save();
            if (!empty($data)) {
                return response()->json(['status' => '1', 'success' => 'Category added successfully.']);
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
            $data = Categories::find($id);
            if (!empty($data)) {
                return view('Admin.Categories.edit', compact('data'));
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
        if ($request->hasFile('category_image')) {

            $validated['category_image']  = "required|mimes:jpg,png,jpeg";
        }

        if ($request->hasFile('icon')) {
        $validated['icon']  = "required|mimes:jpg,png,jpeg";
        }
        foreach (get_language() as $key => $lang) {
            $validated['category_name.' . $lang->code . '.category_name'] = "required";

            $customMessages['category_name.' . $lang->code . '.category_name.required'] = "The ". $lang->language ." Category Name is required.";
        }

        $request->validate($validated,$customMessages);

        try {
            $data = Categories::find($id);
            $data->category_name = json_encode($request->category_name);
            $data->parent_id = $request->parent_id;
            if ($request->hasFile('icon')) {
                File::delete(public_path('icon/'.$data->icon));
                $image = $request->file('icon');
                $uploaded = time() . '_icon.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/icon');
                $image->move($destinationPath, $uploaded);
                $data->icon = $uploaded;
            }

            if ($request->hasFile('category_image')) {
                File::delete(public_path('category_image/'.$data->category_image));


                        $source = $_FILES['category_image']['tmp_name'];
                        if($source){
                                $destinationFolder = public_path('category_image'); // Specify the destination folder
                                $image = $request->file('category_image');
                                $filename =  time() .'_category_image.' . $image->getClientOriginalExtension();
                                if (!file_exists($destinationFolder)) {
                                    mkdir($destinationFolder, 0777, true);
                                }
                                $destination = $destinationFolder . '/' . $filename;
                                $category_image = compressImage($source, $destination);
                                $data->category_image = $filename;
                        }

            }
            $data->update();
            return response()->json(['status' => '1', 'success' => 'Category Updated successfully.']);
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
            $data = Categories::find($id);
            $data->is_delete = 1;
            $data->update();
                   if($data->parent_id == 0)
                   {
                                $data_new = Categories::where("parent_id",$data->id)->get();
                                foreach($data_new as $cate)
                                {
                                     $data = Categories::find($cate->id);
                                     $data->is_delete = 1;
                                     $data->update();
                                }

                   }
            DB::commit(); // Commit Transaction
            return response()->json(['status' => '1', 'success' => 'Category deleted successfully']);
        } catch (\Exception $e) {
            DB::rollBack(); //Rollback Transaction
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }



    public function categoryStatus($id)
    {
        try {
            DB::beginTransaction();
            $data = Categories::find($id);
            if ($data->status == 1) {
                $data->status = 0;
                $message = "Deactived";
            } else {
                $data->status = 1;
                $message = "Actived";
            }
            $data->update();
            DB::commit(); // Commit Transaction
            return response()->json(['status' => '1', 'success' => 'Category ' . $message . ' Successfully']);
        } catch (\Exception $e) {
            DB::rollBack(); //Rollback Transaction
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }




    public function subCategoryList(Request $request)
    {
        $category = Categories::whereIn('parent_id', $request->category_id)->where('is_delete',0)->where('status',1)->get();
        foreach($category as  $cat)
        {
            $cat_array = json_decode($cat['category_name'], true);
            if (!empty($cat_array['en']['category_name'])) {$category_name = $cat_array['en']['category_name'];} else { $category_name = "No Data Found";}
            $cat['category_name_en'] = $category_name;
        }
        return $category;
    }


    public function subCategoryListNew(Request $request)
    {
        dd("hell");
        $category = Categories::whereIn('parent_id', $request->category_id)->where('is_delete',0)->where('status',1)->get();
        foreach($category as  $cat)
        {
            $cat_array = json_decode($cat['category_name'], true);
            if (!empty($cat_array['en']['category_name'])) {$category_name = $cat_array['en']['category_name'];} else { $category_name = "No Data Found";}
            $cat['category_name_en'] = $category_name;
        }
        return $category;
    }


}
