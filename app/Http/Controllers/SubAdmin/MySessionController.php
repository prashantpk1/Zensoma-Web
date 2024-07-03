<?php

namespace App\Http\Controllers\SubAdmin;

use File;
use DataTables;
use App\Models\CategoryType;
use Illuminate\Http\Request;
use App\Models\SessionVideos;
use App\Models\ContentManagement;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MySessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        if ($request->ajax()) {
            $data = ContentManagement::where('creater_id',Auth::user()->id)->where('is_delete',0)->with('category')->orderBY('id','DESC')->get();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $alert_delete = "return confirm('Are you sure want to delete !')";
                    $btn = "<ul class='action'>";
                    if ($row->status == 1) {
                        $btn = $btn . '<li class="delete"> <a   href="javascript:void(0)" href="' . route('my-session.status', $row->id) . '" title="Deactivate" class="status-change" data-url="' . route('my-session.status', $row->id) . '"><i class="fa fa-close"></i></a> </li> ';
                    } else {
                        $btn = $btn . ' <li class="edit"> <a   href="javascript:void(0)" href="' . route('my-session.status', $row->id) . '"   class="status-change" title="Activate" data-url="' . route('my-session.status', $row->id) . '"><i class="icon-check"></i></a></li> ';
                    }
                    // onclick="editcoupon('.$row->id.');"
                    // $btn = $btn .  '<li class="edit"> <a class="edit-data"  href="javascript:void(0)" title="Edit" data-url="'.route('my-session.edit', $row->id).'"><i class="icon-pencil-alt"></i></a></li>';
                    $btn = $btn .  '<li class="edit"> <a class="edit-data"  href="'.route('my-session.edit', $row->id).'" title="Edit"><i class="icon-pencil-alt"></i></a></li>';

                    $btn = $btn . ' <li class="delete"><a href="" data-url="' . route('my-session.destroy', $row->id) . '" class="destroy-data" title="Delete"> <i class="icon-trash"></i></a></li> </ul>';
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

                ->addColumn('duration', function ($data) {
                    if ($data->duration) {
                        return ''.$data->duration.' Minutes';
                    }
                    else
                    {
                        return '<span>Duration Not Found</span>';
                    }
                })


                ->addColumn('category_name', function ($data) {
                    if ($data->category) {

                        $title_array = json_decode($data->category['category_name'], true);
                                    if (!empty($title_array['en']['category_name'])) {$category_name = $title_array['en']['category_name'];} else { $category_name = "No Data Found";}

                        return '<span class="badge bg-success">'.$category_name.'</span>';
                    } else {
                        return '<span class="badge bg-danger">Category Not Found</span>';
                    }
                })

                ->rawColumns(['action', 'status','category_name'])
                ->make(true);
        }
        return view('SubAdmin.MySession.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('SubAdmin.MySession.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {

    //     //
    //      $validated = [];
    //     $validated['duration'] = "required|numeric";
    //     $validated['content_type'] = "required";
    //     // $validated['purchase_type'] = "required";
    //     // $validated['price'] = "required_if:purchase_type,1";
    //     $validated['type_id'] = "required";
    //     $validated['category_id'] = "required";
    //     $validated['main_category_id'] = "required";
    //     $validated['tag_ids'] = "required";
    //     $validated['thumbnail_image'] = "required|mimes:jpg,png,jpeg";
    //     $validated['file'] = "required_if:content_type,video,audio";
    //     foreach (get_language() as $key => $lang) {
    //         $validated['title.' . $lang->code . '.title'] = "required";
    //         $validated['description.' . $lang->code . '.description'] = "required";
    //     }

    //     $request->validate($validated);
    //     $user = Auth::user();

    //     try {
    //         $post = $request->all();
    //         $data = new ContentManagement();

    //          if ($request->hasFile('file')) {
    //             $image = $request->file('file');
    //             $uploaded = time() . '_file.' . $image->getClientOriginalExtension();
    //             $destinationPath = public_path('/file');
    //             $image->move($destinationPath, $uploaded);
    //             $data->file = $uploaded;
    //         }



    //         $image = "";
    //         $uploaded = "";
    //         $destinationPath = "";

    //         if ($request->hasFile('thumbnail_image')) {
    //             // $image = $request->file('thumbnail_image');
    //             // $uploaded = time() . 'thumbnail_image.' . $image->getClientOriginalExtension();
    //             // $destinationPath = public_path('/thumbnail_image');
    //             // $image->move($destinationPath, $uploaded);
    //             // $data->thumbnail = $uploaded;

    //                         $source = $_FILES['thumbnail_image']['tmp_name'];
    //                         if($source){
    //                                 $destinationFolder = public_path('thumbnail_image'); // Specify the destination folder
    //                                 $image = $request->file('thumbnail_image');
    //                                 $filename =  time() .'_thumbnail_image.' . $image->getClientOriginalExtension();
    //                                 if (!file_exists($destinationFolder)) {
    //                                     mkdir($destinationFolder, 0777, true);
    //                                 }
    //                                 $destination = $destinationFolder . '/' . $filename;
    //                                 $thumbnail_image = compressImage($source, $destination);
    //                                 $data->thumbnail = $filename;
    //                         }

    //         }


    //         $data->title = json_encode($request->title);
    //         $data->description = json_encode($request->description);
    //         $data->duration = $request->duration;
    //         $data->content_type  = $request->content_type;
    //         $data->category_id = json_encode($request->category_id);
    //         $data->main_category_id = json_encode($request->main_category_id);
    //         $data->tag_ids = json_encode($request->tag_ids);
    //         // $data->type_id = json_encode($request->type_id);  for multiple
    //         $data->type_id = $request->type_id;
    //         $data->creater_id = $user->id;
    //         $data->creater_name = $user->first_name." ".$user->last_name;
    //         $data->creater_type = "sub_admin";
    //         // $data->price = $request->price;
    //         $data->price = 0;
    //         // $data->purchase_type = $request->purchase_type;
    //         $data->purchase_type = 0;
    //         $data->status = 1;
    //         $data->save();
    //         if (!empty($data)) {
    //             return response()->json(['status' => '1', 'success' => 'Content added successfully.']);
    //         }
    //     } catch (Exception $ex) {
    //         return response()->json(
    //             ['success' => false, 'message' => $ex->getMessage()]
    //         );
    //     }
    // }


    public function store(Request $request)
    {

        $validated = [];
        $customMessages = [];
        $validated['duration'] = "required|numeric";
        $validated['content_type'] = "required";
        $validated['type_id'] = "required";
        $validated['category_id'] = "required";
        $validated['main_category_id'] = "required";
        $validated['tag_ids'] = "required";
        // $validated['thumbnail_image'] = "required|mimes:jpg,png,jpeg";
        // $validated['file'] = "required_if:content_type,video,audio";
        foreach (get_language() as $key => $lang) {
            $validated['title.' . $lang->code . '.title'] = "required";
            $validated['description.' . $lang->code . '.description'] = "required";

            $customMessages['title.' . $lang->code . '.title.required'] = "The " . $lang->language . " Title is required.";
            $customMessages['description.' . $lang->code . '.description.required'] = "The " . $lang->language . " Description is required.";

        }

        $request->validate($validated, $customMessages);
        $user = Auth::user();

        try {
            $post = $request->all();
            $data = new ContentManagement();
            $data->title = json_encode($request->title);
            $data->description = json_encode($request->description);
            $data->duration = $request->duration;
            $data->content_type = $request->content_type;
            $data->tag_ids = json_encode($request->tag_ids);
            $data->category_id = json_encode($request->category_id);
            $data->main_category_id = json_encode($request->main_category_id);
            $data->type_id = $request->type_id;
            $data->creater_id = $user->id;
            $data->creater_name = $user->first_name . " " . $user->last_name;
            $data->creater_type = "admin";
            $data->status = 1;
            $data->save();

            // Handling multiple file uploads
            if ($request->hasFile('file')) {
                $filePaths = [];
                foreach ($request->file('file') as $file) {
                    $uploaded = time() . '_' . uniqid() . '_file.' . $file->getClientOriginalExtension();
                    $destinationPath = public_path('/file');
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0777, true);
                    }
                    $file->move($destinationPath, $uploaded);
                    $filePaths[] = $uploaded;
                }
            }

            // // Handling multiple thumbnail uploads
            if ($request->hasFile('thumbnail_image')) {
                $thumbnailPaths = [];
                foreach ($request->file('thumbnail_image') as $thumbnail_image) {
                    $uploaded = time() . '_' . uniqid() . '_thumbnail_image.' . $thumbnail_image->getClientOriginalExtension();
                    $destinationPath = public_path('/thumbnail_image');
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0777, true);
                    }
                    $thumbnail_image->move($destinationPath, $uploaded);
                    $thumbnailPaths[] = $uploaded;
                }

            }

            if ($data->id) {
                foreach ($thumbnailPaths as $key => $thumbnail) {
                    // dd($key);
                    $field_name = "title_video[$key]";
                    $session_data = new SessionVideos;
                    $session_data->video_title = $request->title_video[$key];
                    $session_data->session_id = $data->id;
                    $session_data->thumbnail_image = $thumbnail;
                    $session_data->video_audio_file = $filePaths[$key];
                    $session_data->status = 1;
                    $session_data->save();

                }

            }

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
        try {
            $data = ContentManagement::with('session_videos')->find($id);
            $count = SessionVideos::count() + 1;
            if ($data->type_id) {
                $type = CategoryType::find($data->type_id);
                $title_array = json_decode($type['type'], true);
                $data['type'] = $title_array['en']['type'] ?? 0;
            } else {
                $data['type'] = "";
            }

            if (!empty($data)) {
                return view('SubAdmin.MySession.edit', compact('data','count'));
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

        $validated = [];
        $customMessages = [];
        $validated['duration'] = "required|numeric";
        $validated['type_id'] = "required";
        $validated['content_type'] = "required";
        $validated['category_id'] = "required";
        $validated['main_category_id'] = "required";
        $validated['tag_ids'] = "required";
        foreach (get_language() as $key => $lang) {
            $validated['title.' . $lang->code . '.title'] = "required";
            $validated['description.' . $lang->code . '.description'] = "required";

            $customMessages['title.' . $lang->code . '.title.required'] = "The " . $lang->language . " Title is required.";
            $customMessages['description.' . $lang->code . '.description.required'] = "The " . $lang->language . " Description is required.";
        }
        $request->validate($validated, $customMessages);

        try {

            $data = ContentManagement::find($id);
            $data->title = json_encode($request->title);
            $data->description = json_encode($request->description);
            $data->duration = $request->duration;
            $data->content_type = $request->content_type;
            $data->category_id = $request->category_id;
            $data->main_category_id = json_encode($request->main_category_id);
            $data->tag_ids = json_encode($request->tag_ids);
            $data->type_id = $request->type_id;
            $data->status = 1;
            $data->save();


            if ($request->title_video) {
                foreach($request->title_video as $title_key => $title_video) {
                        $check_title_video= SessionVideos::find($title_key);
                               if($check_title_video) {
                                            $check_title_video->video_title = $request->title_video[$title_key];
                                            $check_title_video->update();
                                }
                        }
            }

            if ($request->thumbnail_image) {
                foreach ($request->thumbnail_image as $index => $thumbnail) {
                    if (!empty($index)) {
                        $check_thubmnail = SessionVideos::find($index);
                        if ($check_thubmnail) {
                            if ($thumbnail) {
                                File::delete(public_path('thumbnail_image/' . $check_thubmnail->thumbnail_image));

                                $update_thubmnail = time() . '_' . uniqid() . '_thumbnail_image.' . $thumbnail->getClientOriginalExtension();
                                $destinationPath = public_path('/thumbnail_image');
                                if (!file_exists($destinationPath)) {
                                    mkdir($destinationPath, 0777, true);
                                }
                                $thumbnail->move($destinationPath, $update_thubmnail);
                                $check_thubmnail->thumbnail_image = $update_thubmnail;

                            }
                        }
                        $check_thubmnail->video_title = $request->title_video[$index];
                        $check_thubmnail->update();
                    }
                }
            }



            if ($request->file) {
                foreach ($request->file as $index => $file) {
                    if (!empty($index)) {
                        $check_file = SessionVideos::find($index);
                        if ($check_file) {
                            if ($file) {
                                File::delete(public_path('file/' . $check_file->video_audio_file));

                                $update_file = time() . '_' . uniqid() . '_file.' . $file->getClientOriginalExtension();
                                $destinationPath = public_path('/file');
                                if (!file_exists($destinationPath)) {
                                    mkdir($destinationPath, 0777, true);
                                }
                                $file->move($destinationPath, $update_file);
                                $check_file->video_audio_file = $update_file;

                            }
                        }
                        $check_file->update();

                    }
                }
            }



             // Handling multiple file uploads
             if ($request->hasFile('file_new')) {
                $filePaths = [];
                foreach ($request->file('file_new') as $file) {
                    $uploaded = time() . '_' . uniqid() . '_file.' . $file->getClientOriginalExtension();
                    $destinationPath = public_path('/file');
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0777, true);
                    }
                    $file->move($destinationPath, $uploaded);
                    $filePaths[] = $uploaded;
                }
            }

            // Handling multiple thumbnail uploads
            if ($request->hasFile('thumbnail_image_new')) {
                $thumbnailPaths = [];
                foreach ($request->file('thumbnail_image_new') as $thumbnail_image) {
                    $uploaded = time() . '_' . uniqid() . '_thumbnail_image.' . $thumbnail_image->getClientOriginalExtension();
                    $destinationPath = public_path('/thumbnail_image');
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0777, true);
                    }
                    $thumbnail_image->move($destinationPath, $uploaded);
                    $thumbnailPaths[] = $uploaded;
                }

            }

            if (!empty($thumbnailPaths)) {
                foreach ($thumbnailPaths as $key => $thumbnail) {
                    $session_data = new SessionVideos;
                    $session_data->session_id = $data->id;
                    $session_data->thumbnail_image = $thumbnail;
                    $session_data->video_title = $request->title_video_new[$key] ?? "";
                    $session_data->video_audio_file = $filePaths[$key];
                    $session_data->status = 1;
                    $session_data->save();

                }

            }


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
            $data = ContentManagement::find($id);
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




    public function mySessionStatus(string $id)
    {

        try {
            DB::beginTransaction();
            $data = ContentManagement::find($id);
            if ($data->status == 1) {
                $data->status = 0;
                $message = "Deactived";
            } else {
                $data->status = 1;
                $message = "Actived";
            }
            $data->update();
            DB::commit(); // Commit Transaction
            // return redirect()->back()->with('success', 'Content ' . $message . ' Successfully');
            return response()->json(['status' => '1', 'success' => 'Data ' . $message . ' Successfully']);
        } catch (\Exception $e) {
            DB::rollBack(); //Rollback Transaction
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function removeVideo($id)
    {
        $remove_video = SessionVideos::find($id);
        if ($remove_video) {
            $remove_video->is_delete = 1;
            $remove_video->update();
            return redirect()->back()->with('error', 'Data Removed Successfully.');
        } else {
            return redirect()->back()->with('error', 'Video not found.');
        }
    }



}
