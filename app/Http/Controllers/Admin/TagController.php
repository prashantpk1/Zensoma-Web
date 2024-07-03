<?php

namespace App\Http\Controllers\Admin;

use File;
use DataTables;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;

class  TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
         //
        if ($request->ajax()) {
            $data = Tag::where('is_delete',0)->orderBY('id','DESC')->get();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = "<ul class='action'>";
                    if ($row->status == 1) {
                        $btn = $btn . '<li class="delete"> <a  href="javascript:void(0)" href="' . route('tag.status', $row->id) . '" title="Deactivate" class="status-change" data-url="' . route('tag.status', $row->id) . '"><i class="fa fa-close"></i></a>  </li> ';
                    } else {
                        $btn = $btn . '<li class="edit"> <a href="javascript:void(0)" href="' . route('tag.status', $row->id) . '"   class="status-change" title="Activate" data-url="' . route('tag.status', $row->id) . '"><i class="icon-check"></i></a></li> ';
                    }

                    $btn = $btn .  '<li class="edit"> <a class="edit-data"  href="javascript:void(0)" title="Edit" data-url="'.route('tag.edit', $row->id).'"><i class="icon-pencil-alt"></i></a></li>';
                    $btn = $btn . '<li class="delete"><a href="javascript:void(0)" data-url="' . route('tag.destroy', $row->id) . '" class="destroy-data" title="Delete"> <i class="icon-trash"></i></a></li>';
                    $btn = $btn . '</ul>';
                    return $btn;
                })

                ->addColumn('name', function ($data) {
                    $title_array = json_decode($data['tag_name'], true);
                    if (!empty($title_array['en']['tag_name'])) {$data_blog_title = $title_array['en']['tag_name'];} else { $data_blog_title = "No Data Found";}
                    $name = $data->id;
                    return $data_blog_title;
                })

                ->addColumn('image', function ($data) {
                    if ($row['emoji_icon'] = null) {
                        return '<span class="badge badge-soft-success fs-12">no image</span>';
                    } else {
                        return '<img src=' . URL::to('/public') . '/emoji_icon/' . $data->emoji_icon . ' class="img-thumbnail" width="70" height="75"/>';
                    }
                })


                ->addColumn('status', function ($data) {
                    if ($data->status == 1) {
                        return '<span class="badge bg-success">Active</span>';
                    } else {
                        return '<span class="badge bg-danger">In-Active</span>';
                    }
                })
                ->rawColumns(['action','status','name','image'])
                ->make(true);
        }
        return view('Admin.Tags.index');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('Admin.Tags.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        $validated = [];
        $customMessages = [];
        $validated['emoji_icon'] = "required|file|mimes:jpeg,png,jpg";
        foreach (get_language() as $key => $lang) {
            $validated['tag_name.' . $lang->code . '.tag_name'] = ['required'];

            $customMessages['tag_name.' . $lang->code . '.tag_name.required'] = "The ". $lang->language ." Tag name is required.";
        }
        $request->validate($validated,$customMessages);

        try {
            $post = $request->all();
            $data = new Tag();
            $data->tag_name = json_encode($request->tag_name);
            $data->status = 1;

              //image compress
              $source = $_FILES['emoji_icon']['tmp_name'];
              if($source){
                        $destinationFolder = public_path('emoji_icon'); // Specify the destination folder
                        $image = $request->file('emoji_icon');
                        $filename =  time().'emoji_icon.' . $image->getClientOriginalExtension();
                        if (!file_exists($destinationFolder)) {
                            mkdir($destinationFolder, 0777, true);
                        }
                        $destination = $destinationFolder . '/' . $filename;
                        $emoji_icon = compressImage($source, $destination);
                        $data->emoji_icon = $filename;
               }

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
            $data = Tag::find($id);
            if (!empty($data)) {
                return view('Admin.Tags.edit', compact('data'));
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
            $validated['tag_name.' . $lang->code . '.tag_name'] = "required";

            $customMessages['tag_name.' . $lang->code . '.tag_name.required'] = "The ". $lang->language ." Tag name is required.";
        }
        $request->validate($validated,$customMessages);


        try {

            $data =  Tag::find($id);
                // for Image

                if ($request->hasFile('emoji_icon')) {
                    File::delete(public_path('emoji_icon/' . $data->emoji_icon));


                     //image compress
                    $source = $_FILES['emoji_icon']['tmp_name'];
                    if($source){
                                $destinationFolder = public_path('emoji_icon'); // Specify the destination folder
                                $image = $request->file('emoji_icon');
                                $filename =  time().'emoji_icon.' . $image->getClientOriginalExtension();
                                if (!file_exists($destinationFolder)) {
                                    mkdir($destinationFolder, 0777, true);
                                }
                                $destination = $destinationFolder . '/' . $filename;
                                $emoji_icon = compressImage($source, $destination);
                                $data->emoji_icon = $filename;
                    }
                  }



            $data->tag_name = json_encode($request->tag_name);
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

          //
          try {
            DB::beginTransaction();
            $data = Tag::find($id);
            if($data->is_default == 1)
            {
                return response()->json(['status' => '1', 'success' => 'Default data can not detele']);
            }
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



    public function TagStatus(string $id)
    {

        try {
            DB::beginTransaction();
            $data = Tag::find($id);
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
