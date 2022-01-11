<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use DB;

class QuizControlle extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    //add_quiz
    public function addQuiz(Request $request)
    {
		// echo "hello"; die;
		// $data=$request->all();
		// echo "<pre>"; print_r($data);die;
        $validator = Validator::make($request->all(), [
			'title' => 'required|between:2,100',
			'desc' => 'required|string|min:6',
            'maxMark' => 'required|numeric|min:1', 
            'numberOfQuestion' => 'required|numeric|min:1',
            'category' => 'required|string',
        ]);
		if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
		
		$quiz = DB::table('quizzes')->insert([
			'title' => $request->title,
			'desc' => $request->desc,
            'max_mark' => $request->maxMark,
            'number_of_question' => $request->numberOfQuestion,
            'category' => $request->category,
		]);		
		// dd($user);		
        return response()->json([
            'message' => 'Quiz Successfully added',
            'response' => $quiz
        ], 201);
    }

    //list_quiz
    public function listQuiz(){

        $quiz = DB::table('quizzes')->get();
		// dd($user);		
        return response()->json([
            'message' => 'Quiz List !!',
            'response' => $quiz
        ], 201);
    }

    public function deleteQuiz($id){ //obj model ka Curd

        $quiz =DB::table('quizzes')->delete($id);
           
        //dd($curd);
        if($quiz){
            return response()->json($data = [
            'status' => 200,
            'msg'=>'delete Quiz Successfully !!',
            'response' => $quiz
            ]);
        }
        else{
            return response()->json($data = [
            'status' => 201,
            'msg' => 'Data Not Found'
            ]);
        }

    
     }

        //editQuiz
     public function updateQuiz($id, Request $request){ //obj model ka Curd
        dd($request->all());
        die;
        $validator = Validator::make($request->all(), [
			'title' => 'required|between:2,100',
			'desc' => 'required|string|min:6',
            'maxMark' => 'required|numeric|min:1', 
            'numberOfQuestion' => 'required|numeric|min:1',
            'category' => 'required|string',
        ]);
		if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
    
        $quiz =DB::table('quizzes')->where('id', $id)->update([
             
            'title' => $request->title,
			'desc' => $request->desc,
            'max_mark' => $request->maxMark,
            'number_of_question' => $request->numberOfQuestion,
            'category' => $request->category,
        ]);
           
        //dd($curd);
        if($quiz){
            return response()->json($data = [
            'status' => 200,
            'msg'=>' Quiz Update Successfully !!',
            'response' => $quiz
            ]);
        }
        else{
            return response()->json($data = [
            'status' => 201,
            'msg' => 'Data Not Found'
            ]);
        }

    
     }

}
