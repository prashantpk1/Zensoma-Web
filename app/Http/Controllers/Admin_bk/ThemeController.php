<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Theme;
use DataTables;
use File;
use Illuminate\Support\Facades\DB;

class ThemeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
         //
        if ($request->ajax()) {
            $data = Theme::where('is_delete',0)->orderBY('id','DESC')->get();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $alert_delete = "return confirm('Are you sure want to delete !')";
                    $btn = "<ul class='action'>";
                    if ($row->status == 1) {
                        $btn = $btn . '<li class="delete"> <a  href="javascript:void(0)" href="' . route('theme.status', $row->id) . '" title="Deactivate" class="status-change" data-url="' . route('theme.status', $row->id) . '"><i class="fa fa-close"></i></a>  </li> ';
                    } else {
                        $btn = $btn . '<li class="edit"> <a href="javascript:void(0)" href="' . route('theme.status', $row->id) . '"   class="status-change" title="Activate" data-url="' . route('theme.status', $row->id) . '"><i class="icon-check"></i></a></li> ';
                    }

                    
                    $btn = $btn .  '<li class="edit"> <a class="edit-data"  href="javascript:void(0)" title="Edit" data-url="'.route('theme.edit', $row->id).'"><i class="icon-pencil-alt"></i></a></li>';
                    $btn = $btn . '<li class="delete"><a href="javascript:void(0)" data-url="' . route('theme.destroy', $row->id) . '" class="destroy-data" title="Delete"> <i class="icon-trash"></i></a></li>';
                    $btn = $btn . '</ul>';
                    return $btn;
                })

                ->addColumn('title', function ($data) {
                    $title_array = json_decode($data['title'], true);
                    if (!empty($title_array['en']['title'])) {$data_blog_title = $title_array['en']['title'];} else { $data_blog_title = "No Data Found";}
                    $name = $data->id;
                    return $data_blog_title;
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
        return view('Admin.Theme.index');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('Admin.Theme.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        $validated = [];
        $customMessages = [];
        $validated['thumbnail'] = "required|file|mimes:jpeg,png,jpg";
        $validated['file'] = "required|file|mimetypes:video/avi,video/mpeg,video/quicktime,video/mp4,video/x-ms-wmv,video/x-msvideo,video/x-flv";
        foreach (get_language() as $key => $lang) {
            $validated['title.' . $lang->code . '.title'] = ['required','unique:themes,title'];

            $customMessages['title.' . $lang->code . '.title.required'] = "The ". $lang->language ." Title is required.";
        }
       
        $request->validate($validated,$customMessages);

        try {
            $post = $request->all();
            $data = new Theme();
            $data->title = json_encode($request->title);
            $data->status = 1;


              //image compress
              $source = $_FILES['thumbnail']['tmp_name'];
              if($source){
                        $destinationFolder = public_path('thumbnail_image'); // Specify the destination folder
                        $image = $request->file('thumbnail');
                        $filename =  time().'thumbnail.' . $image->getClientOriginalExtension();
                        if (!file_exists($destinationFolder)) {
                            mkdir($destinationFolder, 0777, true);
                        }
                        $destination = $destinationFolder . '/' . $filename;
                        $thumbnail = compressImage($source, $destination);
                        $data->thumbnail = $filename;
               }


            if ($request->hasFile('file')) {
                $image = $request->file('file');
                $uploaded =  time().'file.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/file');
                $image->move($destinationPath, $uploaded);
                $data->file = $uploaded;
            }



            $data->save();
            if (!empty($data)) {
                return response()->json(['status' => '1', 'success' => 'Theme added successfully.']);
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
            $data = Theme::find($id);
            if (!empty($data)) {
                return view('Admin.Theme.edit', compact('data'));
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
            $validated['title.' . $lang->code . '.title'] = "required";

            $customMessages['title.' . $lang->code . '.title.required'] = "The ". $lang->language ." Title is required.";
        }
        $request->validate($validated,$customMessages);


        try {

            $data =  Theme::find($id);

            if($data->is_default == 1){

                // for Image
                if ($request->hasFile('thumbnail')) {
                    File::delete(public_path('thumbnail_image/' . $data->thumbnail));


                    $source = $_FILES['thumbnail']['tmp_name'];
                    if($source){
                              $destinationFolder = public_path('thumbnail_image'); // Specify the destination folder
                              $image = $request->file('thumbnail');
                              $filename =  'thumbnail.' . $image->getClientOriginalExtension();
                              if (!file_exists($destinationFolder)) {
                                  mkdir($destinationFolder, 0777, true);
                              }
                              $destination = $destinationFolder . '/' . $filename;
                              $thumbnail = compressImage($source, $destination);
                              $data->thumbnail = $filename;
                     }
                }

                //for file
                if ($request->hasFile('file')) {
                    File::delete(public_path('file/' . $data->file));
                    $image = $request->file('file');
                    $uploaded = 'default.'. $image->getClientOriginalExtension();
                    $destinationPath = public_path('/file');
                    $image->move($destinationPath, $uploaded);
                    $data->file = $uploaded;
                }

            $uploaded = "";
            $destinationPath = "";
            $image = "";

          }else
          {


            if ($request->hasFile('file')) {
                File::delete(public_path('file/' . $data->file));
                $image = $request->file('file');
                $uploaded = time() . '_file.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/file');
                $image->move($destinationPath, $uploaded);
                $data->file = $uploaded;
            }

            $uploaded = "";
            $destinationPath = "";
            $image = "";

            if ($request->hasFile('thumbnail')) {
                File::delete(public_path('thumbnail_image/' . $data->thumbnail));

                $source = $_FILES['thumbnail']['tmp_name'];
                if($source){
                          $destinationFolder = public_path('thumbnail_image'); // Specify the destination folder
                          $image = $request->file('thumbnail');
                          $filename =  time() .'thumbnail.' . $image->getClientOriginalExtension();
                          if (!file_exists($destinationFolder)) {
                              mkdir($destinationFolder, 0777, true);
                          }
                          $destination = $destinationFolder . '/' . $filename;
                          $thumbnail = compressImage($source, $destination);
                          $data->thumbnail = $filename;
                 }

            }


          }




            $data->title = json_encode($request->title);
            $data->update();
            if (!empty($data)) {
                return response()->json(['status' => '1', 'success' => 'Theme edit Successfully']);
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
            $data = Theme::find($id);
            if($data->is_default == 1)
            {
                return response()->json(['status' => '1', 'success' => 'Default Theme can not detele']);
            }
            $data->is_delete = 1;
            $data->update();
            DB::commit(); // Commit Transaction
            return response()->json(['status' => '1', 'success' => 'Theme deleted successfully']);
        } catch (\Exception $e) {
            DB::rollBack(); //Rollback Transaction
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }



    public function themeStatus(string $id)
    {

        try {
            DB::beginTransaction();
            $data = Theme::find($id);
            if ($data->status == 1) {
                $data->status = 0;
                $message = "Deactived";
            } else {
                $data->status = 1;
                $message = "Actived";
            }
            $data->update();
            DB::commit(); // Commit Transaction
            return response()->json(['status' => '1', 'success' => 'Theme ' . $message . ' Successfully']);
        } catch (\Exception $e) {
            DB::rollBack(); //Rollback Transaction
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }



}
