<?php

namespace App\Http\Controllers\Admin;

use URL;
use Image;
use DataTables;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        if ($request->ajax()) {
            $data = Blog::where('is_delete', 0)->orderBY('id','DESC')->get();
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function ($row) {
                $alert_delete = "return confirm('Are you sure want to delete !')";
                $btn = "<ul class='action'>";
                    if ($row->status == 1) {
                        $btn = $btn . '<li class="delete"> <a   href="javascript:void(0)" href="' . route('blog.status', $row->id) . '" title="Deactivate" class="status-change" data-url="' . route('blog.status', $row->id) . '"><i class="fa fa-close"></i></a>  </li> ';
                    } else {
                        $btn = $btn . ' <li class="edit"> <a   href="javascript:void(0)" href="' . route('blog.status', $row->id) . '"   class="status-change" title="Activate" data-url="' . route('blog.status', $row->id) . '"><i class="icon-check"></i></a></li> ';
                    }

                   $btn = $btn . ' <li class="edit"> <a class="edit-data"  href="javascript:void(0)" title="Edit" data-url="' . route('blog.edit', $row->id) . '"><i class="icon-pencil-alt"></i></a></li>';
                   $btn = $btn . ' <li class="delete"><a href="" data-url="' . route('blog.destroy', $row->id) . '" class="destroy-data" title="Delete"> <i class="icon-trash"></i></a></li>';
                   $btn = $btn .  '  <li class="show"> <a class="show-data"  href="javascript:void(0)" title="Show" data-url="'.route('blog.show', $row->id).'"><i class="icon-eye"></i></a></li> </ul>';
                    return $btn;
                })

                ->addColumn('image', function ($data) {
                    if ($row['blog_image'] = null) {
                        return '<span class="badge badge-soft-success fs-12">no image</span>';
                    } else {
                        return '<img src=' . URL::to('/public') . '/blog_image/' . $data->image . ' class="img-thumbnail" width="70" height="75"/>';
                    }
                })

                ->addColumn('en_title', function ($data) {
                    $title_array = json_decode($data['title'], true);
                    if (!empty($title_array['en']['blog_title'])) {$data_blog_title = $title_array['en']['blog_title'];} else { $data_blog_title = "No Data Found";}
                    return $data_blog_title;
                })

                ->addColumn('status', function ($data) {
                    if ($data->status == 1) {
                        return '<span class="badge bg-success">Active</span>';
                    } else {
                        return '<span class="badge bg-danger">In-Active</span>';
                    }
                })

                ->addColumn('created_at', function ($data) {
                    return date('Y-M-d h:i A', strtotime($data->created_at));
                })


                ->rawColumns(['action','status','is_delete','image','en_title'])
                ->make(true);
        }
        return view('Admin.Blog.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('Admin.Blog.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = [];
        $customMessages = [];
        $validated['key'] = "required";
        $validated['resource_image'] = "required|mimes:jpg,png,jpeg";
        $validated['category_id'] = "required";
        foreach (get_language() as $key => $lang) {
            $validated['blog_title.' . $lang->code . '.blog_title'] = "required";
            $validated['blog_sub_title.' . $lang->code . '.blog_sub_title'] = "required";
            $validated['description.' . $lang->code . '.description'] = "required";

            $customMessages['blog_title.' . $lang->code . '.blog_title.required'] = "The ". $lang->language ." Resource Title is required.";
            $customMessages['blog_sub_title.' . $lang->code . '.blog_sub_title.required'] = "The ". $lang->language ." Resource Sub Title is required.";
            $customMessages['description.' . $lang->code . '.description.required'] = "The ". $lang->language ." Description is required.";
        }

        $request->validate($validated,$customMessages);

        $data = new Blog;
        $uploaded = '';

        //for image
        if ($request->hasFile('resource_image')) {

            $source = $_FILES['resource_image']['tmp_name'];
            if($source){
                      $destinationFolder = public_path('blog_image'); // Specify the destination folder
                      $image = $request->file('resource_image');
                      $filename =  time() .'_blog_image.' . $image->getClientOriginalExtension();
                      if (!file_exists($destinationFolder)) {
                          mkdir($destinationFolder, 0777, true);
                      }
                      $destination = $destinationFolder . '/' . $filename;
                      $blog_image = compressImage($source, $destination);
                      $data->image = $filename;
             }
        }

        $data->status = 1;
        $lowercaseString = strtolower($request->key);
        $data->key = str_replace(' ', '_', $lowercaseString);
        $data->language = json_encode($request->language);
        $data->title = json_encode($request->blog_title);
        $data->sub_title = json_encode($request->blog_sub_title);
        $data->description = json_encode($request->description);
        $data->category_id = $request->category_id;
        $data->created_by = Auth::user()->id;
        $data->save();
        if (!empty($data)) {
        return response()->json(['status' => '1', 'success' => 'Resource Added Successfully']);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        // dd($id);
        try {
            $data = Blog::find($id);
            if (!empty($data)) {
                return view('Admin.Blog.show', compact('data'));
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
            $data = Blog::find($id);
            if (!empty($data)) {
                return view('Admin.Blog.edit', compact('data'));
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
        $validated['key'] = "required";
        $validated['category_id'] = "required";

        if ($request->hasFile('blog_image')) {
            $validated['blog_image']  = "required|mimes:jpg,png,jpeg";
        }

        foreach (get_language() as $key => $lang) {
            $validated['blog_title.' . $lang->code . '.blog_title'] = "required";
            $validated['blog_sub_title.' . $lang->code . '.blog_sub_title'] = "required";
            $validated['description.' . $lang->code . '.description'] = "required";


            $customMessages['blog_title.' . $lang->code . '.blog_title.required'] = "The ". $lang->language ." Resource Title is required.";
            $customMessages['blog_sub_title.' . $lang->code . '.blog_sub_title.required'] = "The ". $lang->language ." Resource Sub Title is required.";
            $customMessages['description.' . $lang->code . '.description.required'] = "The ". $lang->language ." Description is required.";

        }
        $request->validate($validated,$customMessages);

        try {
            $data = Blog::find($id);

            if ($request->hasFile('blog_image')) {
                File::delete(public_path('blog_image/' . $data->blog_image));

                $source = $_FILES['blog_image']['tmp_name'];
                if($source){
                          $destinationFolder = public_path('blog_image'); // Specify the destination folder
                          $image = $request->file('blog_image');
                          $filename =  time() .'_blog_image.' . $image->getClientOriginalExtension();
                          if (!file_exists($destinationFolder)) {
                              mkdir($destinationFolder, 0777, true);
                          }
                          $destination = $destinationFolder . '/' . $filename;
                          $blog_image = compressImage($source, $destination);
                          $data->image = $filename;
                 }

            }

            $data->status = 1;
            $lowercaseString = strtolower($request->key);
            $data->key = str_replace(' ', '_', $lowercaseString);
            $data->language = json_encode($request->language);
            $data->title = json_encode($request->blog_title);
            $data->sub_title = json_encode($request->blog_sub_title);
            $data->description = json_encode($request->description);
            $data->category_id = $request->category_id;
            $data->update();
            if (!empty($data)) {
            return response()->json(['status' => '1', 'success' => 'Resource Updated successfully']);
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
            $data = Blog::find($id);
            $data->is_delete = 1;
            $data->update();
            DB::commit(); // Commit Transaction
            return response()->json(['status' => '1', 'success' => 'Resource deleted successfully']);
        } catch (\Exception $e) {
            DB::rollBack(); //Rollback Transaction
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function blogStatus($id)
    {
        try {
            DB::beginTransaction();
            $data = Blog::find($id);
            if ($data->status == 1) {
                $data->status = 0;
                $message = "Deactived";
            } else {
                $data->status = 1;
                $message = "Actived";
            }
            $data->update();
            DB::commit(); // Commit Transaction
            return response()->json(['status' => '1', 'success' => 'Resource ' . $message . ' Successfully']);
        } catch (\Exception $e) {
            DB::rollBack(); //Rollback Transaction
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

}
