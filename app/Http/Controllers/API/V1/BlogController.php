<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Blog;
use App\Models\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use App\Http\Resources\BlogDetailResource;

class BlogController extends Controller
{
    //
    public function getBlogs(Request $request)
    {
        $language_code =  $request->header('language');
        $language = Language::where('code', $language_code)->where('status',1)->where('is_delete',0)->first();
        if (empty($language)) {
            return response()->json(
                [ 'status' => 0,'message' =>'Invalied Language Code'], 401
            );
        }
        try {

            $blogs = Blog::with('category_name', 'create_name')->where("category_id", $request->category_id)->where('is_delete', 0)->where('status', 1);

               if($request->search)
               {

                    $blogs->where('title', 'LIKE', '%' . $request->search . '%');

               }



                // $total = $data->count();
                    // $data = $data->paginate(10);


                $total = $blogs->count();
                $data = $blogs->paginate(10);
                // dd($data);
                $blog_data = BlogResource::collection($data);
                return response()->json(
                    [
                        'data' => $blog_data,
                        'status' => 1,
                        'total' => $total,
                        'message' => get_label("blogs_list_get_successfully",$language_code),
                    ], 200);

        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }

    }


    public function getBlog(Request $request)
    {

        $language_code =  $request->header('language');
        $language = Language::where('code', $language_code)->where('status',1)->where('is_delete',0)->first();
        if (empty($language)) {
            return response()->json(
                [ 'status' => 0,'message' =>'Invalied Language Code'], 401
            );
        }

        $validated = [];
        $validated['blog_id'] = "required";

        $customMessages = [
            'blog_id.required' => get_label("the_blog_id_field_is_required",$language_code),
        ];

        $request->validate($validated, $customMessages);


        $language = Language::where('code', $language_code)->where('status',1)->where('is_delete',0)->first();
        if (empty($language)) {
            return response()->json(
                [ 'status' => 0,'message' =>'Invalied Language Code'], 401
            );
        }
        try {
                $data = Blog::with('category_name', 'create_name')->find($request->blog_id);
                if($data){
                $blog_data = new BlogDetailResource($data);
                return response()->json(
                    [
                        'data' => $blog_data,
                        'status' => 1,
                        'message' => get_label("blog_detail_get_successfully",$language_code),
                    ], 200);
                }
                else
                {
                    return response()->json(
                    [
                        'data' => [],
                        'status' => 1,
                        'message' => get_label("somthing_went_wrong",$language_code),
                    ], 200);
                }

        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }

    }


}
