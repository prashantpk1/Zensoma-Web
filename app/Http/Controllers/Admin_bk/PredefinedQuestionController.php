<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Option;
use App\Models\PredefinedQuestion;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PredefinedQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        if ($request->ajax()) {
            $data = PredefinedQuestion::where('is_delete', 0)->orderBY('id', 'DESC')->get();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $alert_delete = "return confirm('Are you sure want to delete !')";
                    $btn = "<ul class='action'>";
                    if ($row->status == 1) {
                        $btn = $btn . '<li class="delete"> <a   href="javascript:void(0)" href="' . route('question.status', $row->id) . '" title="Deactivate" class="status-change" data-url="' . route('question.status', $row->id) . '"><i class="fa fa-close"></i></a> </li> ';
                    } else {
                        $btn = $btn . ' <li class="edit"> <a   href="javascript:void(0)" href="' . route('question.status', $row->id) . '"   class="status-change" title="Activate" data-url="' . route('question.status', $row->id) . '"><i class="icon-check"></i></a></li> ';
                    }
                    $btn = $btn . '<li class="edit"> <a class="edit-data"  href="javascript:void(0)" title="Edit" data-url="' . route('question.edit', $row->id) . '"><i class="icon-pencil-alt"></i></a></li>';

                    $btn = $btn . ' <li class="delete"><a href="" data-url="' . route('question.destroy', $row->id) . '" class="destroy-data" title="Delete"> <i class="icon-trash"></i></a></li> </ul>';
                    return $btn;

                })

                ->addColumn('question', function ($data) {
                    $title_array = json_decode($data['question'], true);
                    if (!empty($title_array['en']['question'])) {$data_blog_title = $title_array['en']['question'];} else { $data_blog_title = "No Data Found";}
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
                ->rawColumns(['action', 'status', 'id'])
                ->make(true);
        }
        return view('Admin.Predefined-Questions.index');
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
        $validated['option_type'] = "required";
        $validated['category_id'] = "required";
        foreach (get_language() as $key => $lang) {
            $validated['question.' . $lang->code . '.question'] = "required";
            $validated['description.' . $lang->code . '.description'] = "required";
            // $validated['option.' . $lang->code . '.option'] = "required";

            $customMessages['question.' . $lang->code . '.question.required'] = "The " . $lang->language . " Question is required.";
            $customMessages['description.' . $lang->code . '.description.required'] = "The " . $lang->language . " Description is required.";
            // $customMessages['option.' . $lang->code . '.option.required'] = "The " . $lang->language . " option is required.";
        }

        $request->validate($validated, $customMessages);

        try {
            $post = $request->all();
            $option_type = $request->option_type;
            $question = $request->question;
            $option = $request->option;
            $data = new PredefinedQuestion();
            $data->category_id = json_encode($request->category_id);
            $data->option_type = $request->option_type;
            $data->question = json_encode($request->question);
            $data->descriptions = json_encode($request->description);
            if ($request->option_type == "range") {
                $data->options = $request->start_number . "-" . $request->end_number;
            } else {
                $data->options = null;
            }
            $data->status = 1;
            $data->save();
            if ($option_type != "range") {
                foreach ($option as $key => $op) {
                    foreach ($op as $key1 => $op_new) {
                        $data1 = new Option();
                        $data1->question_id = $data->id;
                        $data1->option = $op_new;
                        $data1->language = $key;
                        $data1->option_order = $key1 + 1;
                        $data1->save();

                    }
                }

            }
            if (!empty($data)) {
                return response()->json(['status' => '1', 'success' => 'Question added successfully.']);
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
            $data = PredefinedQuestion::with('option')->find($id);
            $defultLanguage = Language::select('code', 'language')->where('status', 1)->where('is_delete', 0)->orderBy('id', 'ASC')->first();
            if (!empty($data)) {
                return view('Admin.Predefined-Questions.edit', compact('data', 'defultLanguage'));
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
            $validated['question.' . $lang->code . '.question'] = "required";
            $validated['description.' . $lang->code . '.description'] = "required";
            // $validated['option.' . $lang->code . '.option'] = "required";

            $customMessages['question.' . $lang->code . '.question.required'] = "The " . $lang->language . " Question is required.";
            $customMessages['description.' . $lang->code . '.description.required'] = "The " . $lang->language . " Description is required.";
            // $customMessages['option.' . $lang->code . '.option.required'] = "The " . $lang->language . " option is required.";
        }

        $request->validate($validated, $customMessages);

        try {
            $post = $request->all();
            $data = PredefinedQuestion::find($id);
            $option_type = $data->option_type;
            $option = $request->option;
            $data->question = json_encode($request->question);
            $data->descriptions = json_encode($request->description);
            $data->category_id = json_encode($request->category_id);
            if ($data->option_type == "range") {
                $data->options = $request->start_number . "-" . $request->end_number;
            } else {
                $data->options = json_encode($request->option);
            }
            $data->status = 1;
            $data->save();

            $question_id = $data->id;

            Option::where('question_id', $question_id)->delete();

            if ($option_type != "range") {
                foreach ($option as $key => $op) {
                    foreach ($op as $key1 => $op_new) {
                        $data1 = new Option();
                        $data1->question_id = $data->id;
                        $data1->option = $op_new;
                        $data1->language = $key;
                        $data1->option_order = $key1;
                        $data1->save();

                    }
                }

            }

            if (!empty($data)) {
                return response()->json(['status' => '1', 'success' => 'Question Update successfully.']);
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
            $data = PredefinedQuestion::find($id);
            if ($data['is_default'] == 0) {
                $data->is_delete = 1;
                $data->update();
                DB::commit(); // Commit Transaction
                return response()->json(['status' => '1', 'success' => 'Question Deleted Successfully']);
            } else {
                return response()->json(['status' => '1', 'success' => 'You dont have permission to delete default question..']);
            }
        } catch (\Exception $e) {
            DB::rollBack(); //Rollback Transaction
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function questionStatus(string $id)
    {
        try {
            DB::beginTransaction();
            $data = PredefinedQuestion::find($id);
            if ($data->status == 1) {
                $data->status = 0;
                $message = "Deactived";
            } else {
                $data->status = 1;
                $message = "Actived";
            }
            $data->update();
            DB::commit(); // Commit Transaction
            return response()->json(['status' => '1', 'success' => 'Question ' . $message . ' Successfully']);
        } catch (\Exception $e) {
            DB::rollBack(); //Rollback Transaction
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

}
