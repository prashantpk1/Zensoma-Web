<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cms;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CmsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        if ($request->ajax()) {
            $data = Cms::where('is_delete',0)->orderBY('id','DESC')->get();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $alert_delete = "return confirm('Are you sure want to delete !')";
                    $btn = "<ul class='action'>";
                    $btn = $btn .  '<li class="edit"> <a class="edit-data"  href="javascript:void(0)" title="Edit" data-url="'.route('cms.edit', $row->id).'"><i class="icon-pencil-alt"></i></a></li>  </ul>';
                    return $btn;

                })
                ->addColumn('title', function ($data) {
                    $title_array = json_decode($data['title'], true);
                    if (!empty($title_array['en']['title'])) {$data_blog_title = $title_array['en']['title'];} else { $data_blog_title = "No Data Found";}
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

                ->addColumn('updated_at', function ($data) {
                    return date('Y-M-d h:i A', strtotime($data->updated_at));

                })
                ->rawColumns(['action', 'status', 'id'])
                ->make(true);
        }
        return view('Admin.Cms-Pages.index');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('Admin.Cms-Pages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = [];
        $validated = [];
        $validated['slug'] = "required";
        foreach (get_language() as $key => $lang) {
            $validated['title.' . $lang->code . '.title'] = "required";
            $validated['content.' . $lang->code . '.content'] = "required";

            $customMessages['title.' . $lang->code . '.title.required'] = "The ". $lang->language ." Title is required.";
            $customMessages['content.' . $lang->code . '.content.required'] = "The ". $lang->language ." Content is required.";

        }

        $request->validate($validated,$customMessages);

        try {
            $post = $request->all();
            $data = new Cms();
            $data->slug = $request->slug;
            $data->title = json_encode($request->title);
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
            $data = Cms::find($id);
            if (!empty($data)) {
                return view('Admin.Cms-Pages.edit', compact('data'));
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
            $validated['content.' . $lang->code . '.content'] = "required";

            $customMessages['title.' . $lang->code . '.title.required'] = "The ". $lang->language ." Title is required.";
            $customMessages['content.' . $lang->code . '.content.required'] = "The ". $lang->language ." Content is required.";
        }

        $request->validate($validated,$customMessages);

        try {
            $data = Cms::find($id);
            $data->title = json_encode($request->title);
            $data->content = json_encode($request->content);
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
            // Cms::find($id)->delete();
            $data = Cms::find($id);
            $data->is_delete = 1;
            $data->update();
            DB::commit(); // Commit Transaction
            return response()->json(['status' => '1', 'success' => 'Data Deleted Successfully']);
        } catch (\Exception $e) {
            DB::rollBack(); //Rollback Transaction
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function cmsStatus($id)
    {
        try {
            DB::beginTransaction();
            $data = Cms::find($id);
            if ($data->status == 1) {
                $data->status = 0;
                $message = "Deactived";
            } else {
                $data->status = 1;
                $message = "Actived";
            }
            $data->update();
            DB::commit(); // Commit Transaction
            return redirect()->back()->with('success', 'Data ' . $message . ' Successfully');
        } catch (\Exception $e) {
            DB::rollBack(); //Rollback Transaction
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function getCmsPageContent($id)
    {
        $numberArray = explode('-',$id);
        $data = Cms::where('slug',$numberArray[0])->first();
        if($data) {
            $title = json_decode($data['title']);
            $content = json_decode($data['content']);
            $language = $numberArray[1];
            $page_title = $title->$language->title ?? "";
            $page_content = $content->$language->content ?? "";
            return view('content', compact('data','page_title','page_content'));
        }
        else
        {
              echo "page not foound";
        }

    }



}
