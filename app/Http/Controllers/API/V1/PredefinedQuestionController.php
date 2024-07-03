<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PredefinedQuestionResource;
use App\Models\Language;
use App\Models\Option;
use App\Models\PredefinedAnswer;
use App\Models\PredefinedQuestion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PredefinedQuestionController extends Controller
{
    //

    public function getPredefinedQuestions(Request $request)
    {
        $language_code = $request->header('language');
        $language = Language::where('code', $language_code)->where('status', 1)->where('is_delete', 0)->first();
        if (empty($language)) {
            return response()->json(
                ['status' => 0, 'message' => 'Invalied Language Code'], 401
            );
        }
        $category_id =  $request->category_id;
        try {

            $validated = [];
            // $validated['sender_id'] = "required";
            $validated['category_id'] = "required";

            $customMessages = [
                'category_id.required' => get_label("the_category_id_field_is_required",$language_code),
            ];

            $request->validate($validated, $customMessages);


            $data = PredefinedQuestion::where(function ($query) use ($request) {
                // If is_default is 1, skip the whereJsonContains condition
                $query->where('is_default', '<>', 1)
                      ->whereJsonContains('category_id', [$request->category_id]);
            })
            ->orWhere('is_default', 1) // Add where condition for is_default = 1
            ->where('status', 1)
            ->where('is_delete', 0)
            ->orderBy('id', 'ASC')
            ->get();


            foreach ($data as $que) {
                $que['option'] = Option::where('question_id', $que->id)->where('language', $request->header('language'))->orderBy('option_order', 'ASC')->get();
            }
            $pre_que_data = PredefinedQuestionResource::collection($data);
            return response()->json(
                [
                    'data' => $pre_que_data,
                    'status' => 1,
                    'message' => get_label("predefined_question_list_get_successfully",$language_code),
                ], 200);

        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }

    }

    public function predefinedQuestionAnswersSave(Request $request)
    {


        $language_code = $request->header('language');
        $language = Language::where('code', $language_code)->where('status', 1)->where('is_delete', 0)->first();
        if (empty($language)) {
            return response()->json(
                ['status' => 0, 'message' => 'Invalied Language Code'], 401
            );
        }

        $validated = [];
        $validated['answers'] = "required";

        $customMessages = [
            'answers.required' => get_label("the_answers_field_is_required",$language_code),
        ];

        $request->validate($validated, $customMessages);

        try {




            $id = Auth::user()->id;
            $user_data = User::find($id);
            $data = PredefinedAnswer::where('user_id', $id)->first();
            if (empty($data)) {
                $data_new = new PredefinedAnswer();
                $data_new->user_id = Auth::user()->id ?? 0;
                $data_new->answers = $request->answers;
                $data_new->save();

                $jsonArray = json_decode($request->answers);

                if($jsonArray){
                $key = 0;
                        foreach ($jsonArray as $key => $question) {

                            if ($question->question_id == 21) {
                                //Save User Age to users table ?

                                if($question->value  == "")
                                $user_data->age = $question->value;
                               
                                $key++;
                            }


                            if ($question->question_id == 22) {
                                //Save User Age to users table ?
                                $user_data->age = $question->value;
                                $key++;
                            }

                            if ($question->question_id == 23) {
                                //Save User Height(inch) to users table?
                                $user_data->height = $question->value;
                                $key++;
                            }

                            if ($question->question_id == 24) {
                                //Save User Weight to users table ?
                                $user_data->weight = $question->value;
                                $key++;
                            }

                        }

                        $user_data->update();
                }

                if ($data_new) {
                    return response()->json(
                        [
                            'status' => 1,
                            'message' => get_label("predefined_question_answer_save_successfully",$language_code),
                        ], 200);
                }

            } else {

                return response()->json(
                    [
                        'status' => 1,
                        'message' => get_label("predefined_question_answer_already_submitted",$language_code),
                    ], 200);
            }

        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }

    }


    // public function predefinedQuestionAnswersSaveTest(Request $request)
    // {

    //     $validated = [];
    //     $validated['answers'] = "required";
    //     $request->validate($validated);
    //     try {

    //         $id = Auth::user()->id;
    //         $user_data = User::find($id);
    //         $data = PredefinedAnswer::where('user_id', $id)->first();
    //         if (empty($data)) {
    //             $data_new = new PredefinedAnswer();
    //             $data_new->user_id = Auth::user()->id ?? 0;
    //             $data_new->answers = $request->answers;
    //             $data_new->save();

    //             $jsonArray = json_decode($request->answers);

    //             $key = 0;
    //             foreach ($jsonArray as $key => $question) {

    //                 if ($question->question_id == 22) {
    //                     //Save User Age to users table ?
    //                     $user_data['age'] = $question->value;
    //                     $key++;
    //                 }

    //                 if ($question->question_id == 23) {
    //                     //Save User Height(inch) to users table?
    //                     $user_data['height'] = $question->value;
    //                     $key++;
    //                 }

    //                 if ($question->question_id == 24) {
    //                     //Save User Weight to users table ?
    //                     $user_data['weight'] = $question->value;
    //                     $key++;
    //                 }

    //             }

    //             $user_data->update();

    //             if ($data_new) {
    //                 return response()->json(
    //                     [
    //                         'status' => 1,
    //                         'message' => "Predefined question answer save Successfully",
    //                     ], 200);
    //             }

    //         } else {

    //             return response()->json(
    //                 [
    //                     'status' => 1,
    //                     'message' => "Predefined question answer already submited",
    //                 ], 200);
    //         }

    //     } catch (Exception $ex) {
    //         return response()->json(
    //             ['success' => 0, 'message' => $ex->getMessage()], 401
    //         );
    //     }

    // }




}
