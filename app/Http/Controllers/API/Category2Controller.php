<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use DB;

class Category2Controller extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function addCategory (Request $request)
    {
		// echo "hello"; die;
		// $data=$request->all();
		// echo "<pre>"; print_r($data);die;
        $validator = Validator::make($request->all(), [
			'title' => 'required|between:2,100',
			'desc' => 'required|string|min:6',
        ]);
		if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
		
		$categories = DB::table('categories')->insert([
			'title' => $request->title,
			'desc' => $request->desc,
		]);		
		// dd($user);		
        return response()->json([
            'message' => 'Category Successfully added',
            'response' => $categories
        ], 201);
    }

    public function categoryList(){

        $listCategory = DB::table('categories')->get();
		// dd($user);		
        return response()->json([
            'message' => 'Category List !!',
            'response' => $listCategory
        ], 201);
    }

    public function deleteCategory($id){ //obj model ka Curd

        $category =DB::table('categories')->delete($id);
           
        //dd($curd);
        if($category){
            return response()->json($data = [
            'status' => 200,
            'msg'=>'delete Category Successfully !!',
            'response' => $category
            ]);
        }
        else{
            return response()->json($data = [
            'status' => 201,
            'msg' => 'Data Not Found'
            ]);
        }

    
     }


     public function updateCategory($id, Request $request){ //obj model ka Curd

        $validator = Validator::make($request->all(), [
			'title' => 'required|between:2,100|string',
			'desc' => 'required|string|min:6',
        ]);
		if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
    
        $category =DB::table('categories')->where('id', $id)->update([
             
            'title' => $request->title,
			'desc' => $request->desc,
        ]);
           
        //dd($curd);
        if($category){
            return response()->json($data = [
            'status' => 200,
            'msg'=>'update Category Successfully !!',
            'response' => $category
            ]);
        }
        else{
            return response()->json($data = [
            'status' => 201,
            'msg' => 'Data Not Found'
            ]);
        }

    
     }
    //  public function userCategory()
    //  {
    //      return response()->json(auth('api')->user());
    //  }
}
