<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Quote;
use App\Models\Words;
use App\Models\Country;
use App\Models\Language;
use App\Models\Categories;
use App\Models\CategoryType;
use Illuminate\Http\Request;
use App\Models\MultiLanguage;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\LanguageResource;
use App\Http\Resources\CategoryMasterResource;

class CategoryController extends Controller
{
    //

    public function getCategories(Request $request)
    {
        $language_code = $request->header('language');
        $language = Language::where('code', $language_code)->where('status', 1)->where('is_delete', 0)->first();
        if (empty($language)) {
            return response()->json(
                ['status' => 0, 'message' => 'Invalied Language Code'], 401
            );
        }
        try {
            $data = Categories::where('parent_id',0)->where('status', 1)->where('is_delete', 0)->get();
            $cate_data = CategoryResource::collection($data);
            return response()->json(
                [
                    'data' => $cate_data,
                    'status' => 1,
                    'message' => get_label("categories_list_get_successfully",$language_code),
                ], 200);

        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }

    }

    public function getSubCategories($id)
    {
        try {
            $data = Categories::where('parent_id', $id)->where('status', 1)->where('is_delete', 0)->get();
            $cate_data = CategoryResource::collection($data);
            return response()->json(
                [
                    'data' => $cate_data,
                    'status' => 1,
                    'message' => "Category List",
                ], 200);

        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }

    }

    public function getLanguages(Request $request)
    {
        try {
            $language_code = $request->header('language');
            $language = Language::where('code', $language_code)->where('status', 1)->where('is_delete', 0)->first();
            if (empty($language)) {
                return response()->json(
                    ['status' => 0, 'message' => 'Invalied Language Code'], 401
                );
            }
            $data = Language::where('status', 1)->where('is_delete', 0)->get();
            $lang_data = LanguageResource::collection($data);
            return response()->json(
                [
                    'data' => $lang_data,
                    'status' => 1,
                    'message' => get_label("languages_list_get_successfully",$language_code),
                ], 200);
        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }

    }

    public function getCountrys(Request $request)
    {
        try {
            $language_code = $request->header('language');
            $language = Language::where('code', $language_code)->where('status', 1)->where('is_delete', 0)->first();
            if (empty($language)) {
                return response()->json(
                    ['status' => 0, 'message' => 'Invalied Language Code'], 401
                );
            }
            $data = Country::select('id', 'country_name')->get();
            return response()->json(
                [
                    'data' => $data,
                    'status' => 1,
                    'message' => get_label("countries_list_get_successfully",$language_code),
                ], 200);
        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }

    }

    public function randomQuote(Request $request)
    {

        $language_name = $request->header('language');
        $language = Language::where('code', $language_name)->where('status', 1)->where('is_delete', 0)->first();
        if (empty($language)) {
            return response()->json(
                ['status' => 0, 'message' => 'Invalied Language Code'], 401
            );
        }
        try {

            $lebal = MultiLanguage::where('is_delete', 0)->where('key', "start_screen_message")->first();
            $label_new = Json_decode($lebal->content);
            $label_1 = $label_new->$language_name->content;
            $data = Quote::select('id', 'text')->where('status', 1)->where('is_delete', 0)->inRandomOrder()->first();
            if (!empty($data)) {
                $text = json_decode($data->text);
                $data['text'] = $text->$language_name->text ?? "";
                $data['label'] = $label_1 ?? "";

                return response()->json(
                    [
                        'data' => $data,
                        'status' => 1,
                        'message' => get_label("get_quote_successfully",$language_name),
                    ], 200);
            } else {
                return response()->json(
                    [
                        'status' => 0,
                        'message' => get_label("somthing_went_wrong",$language_name),
                    ], 200);
            }

        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }
    }

    public function serachWord(Request $request)
    {

        $language_code = $request->header('language');
            $language = Language::where('code', $language_code)->where('status', 1)->where('is_delete', 0)->first();
            if (empty($language)) {
                return response()->json(
                    ['status' => 0, 'message' => 'Invalied Language Code'], 401
                );
            }

        $validated = [];
        $validated['word'] = "required";

        $customMessages = [
            'word.required' => get_label("the_word_field_is_required",$language_code),
        ];

       $request->validate($validated, $customMessages);


        $request->validate($validated);


        try {
            $word = trim($request->word);
            $data = Words::where('word',$word)->first();
            if (empty($data)) {
               $data = new Words();
               $data->word = $word;
               $data->status = 1;
               $data->volumes = 1;
               $data->is_delete = 0;
               $data->save();

               if($data) {
                return response()->json(
                    [
                        'status' => 1,
                        'message' => get_label("word_added_to_word_list",$language_code),
                    ], 200);
               }
            } else {
              $data->volumes = $data->volumes + 1;
              $data->update();

                return response()->json(
                    [
                        'status' => 1,
                        'message' => get_label("word_already_added_to_word_list_volumes_increse",$language_code),
                    ], 200);
            }
        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }



    }


   public  function getCategoriesSubcategoriesTypes(Request $request)
    {


        $language_code = $request->header('language');
        $language = Language::where('code', $language_code)->where('status', 1)->where('is_delete', 0)->first();
        if (empty($language)) {
            return response()->json(
                ['status' => 0, 'message' => 'Invalied Language Code'], 401
            );
        }
        try {
                    //api start
                    $language = "";
                    $language = $request->header('language');
                    $data = Categories::select('id','category_name','icon','category_image')->where('parent_id',0)->where('status', 1)->where('is_delete', 0)->get();
                    foreach($data  as $cat)
                    {
                        //for language main category
                        $category_name_array  = json_decode($cat['category_name']);
                        $category_name_en  = $category_name_array->$language->category_name;
                        $cat['category_name'] = $category_name_en ?? "No Category Name Found";
                        $cat['icon'] =  URL::to('/public') . '/icon/' .$cat->icon ?? "";
                        $cat['category_image'] =  URL::to('/public') . '/category_image/' .$cat->category_image ?? "";
                        //for language main category

                        $sub_category = Categories::select('id','category_name','icon','category_image')->where('parent_id',$cat->id)->where('status', 1)->where('is_delete', 0)->get();
                        foreach($sub_category as $sub_cate)
                        {


                            $sub_category_name_array  = json_decode($sub_cate['category_name']);
                            $category_name_en  = $sub_category_name_array->$language->category_name;
                            $sub_cate['sub_category_name'] = $category_name_en ?? "No Category Name Found";
                            $sub_cate['icon'] =  URL::to('/public') . '/icon/' .$sub_cate->icon ?? "";
                            $sub_cate['category_image'] =  URL::to('/public') . '/category_image/' .$sub_cate->category_image ?? "";

                            $type = CategoryType::select('id','type')->where('category_id',$sub_cate->id)->get();
                            foreach($type as $ty)
                            {
                                $type_array  = json_decode($ty['type']);
                                $type_name_en  = $type_array->$language->type;
                                $ty['type'] = $type_name_en ?? "No Category Name Found";
                            }
                            $sub_cate['Types'] = $type;


                            unset($sub_cate['category_name']);
                        }
                        $cat['sub_categories'] = $sub_category;
                    }

                    $cate_data = CategoryMasterResource::collection($data);
                    return response()->json(
                        [
                            'data' => $cate_data,
                            'status' => 1,
                            'message' => get_label("categories_list_get_successfully",$language_code),
                        ], 200);

                    //api end

            } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }


    }

}
