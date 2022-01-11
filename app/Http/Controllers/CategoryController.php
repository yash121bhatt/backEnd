<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Category;
use App\Auth;
use DB;

class CategoryController extends Controller
{
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
		
		$category = Category::create([
			'title' => $request->title,
			'desc' => $request->desc,
		]);		
		// dd($user);		
        return response()->json([
            'message' => 'Category Successfully added',
            'response' => $category
        ], 201);
    }
}
