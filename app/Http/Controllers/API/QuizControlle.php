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
            'category' => 'required',
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

    //    echo auth('api')->user()->user_type;
       
       if(auth('api')->user()->user_type == 'ADMIN')
       {
        $quiz = DB::table('quizzes')->get();   
       }
       else{
        $quiz = DB::table('quizzes')->where('status', 1)->get();
       }
       
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
     public function updateQuiz(Request $request,$id=null){ //obj model ka Curd
        // echo $id;
        // die;
        // dd($request->all());
        // die;
        $validator = Validator::make($request->all(), [
			'title' => 'required|between:2,100',
			'desc' => 'required|string|min:6',
            'max_mark' => 'required|numeric|min:1', 
            'number_of_question' => 'required|numeric|min:1',
            'category' => 'required',
        ]);
		if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        //  echo $id;
        //  die;
        $quiz =DB::table('quizzes')->where('id', $id)->update([
            'title' => $request->title,
			'desc' => $request->desc,
            'max_mark' => $request->max_mark,
            'number_of_question' => $request->number_of_question,
            'category' => $request->category,
        ]);
           
        // dd($quiz);
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
     //get Quiz
     public function getQuiz($catName){ //obj model ka Curd

        $quiz =DB::table('quizzes')->where('category',$catName)->get(); 
        //dd($curd);
        if($quiz){
            return response()->json($data = [
            'status' => 200,
            'msg'=>'Show Quiz Data !!',
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

       
      //get Quiz
      public function editQuiz($id){ //obj model ka Curd

        $quiz =DB::table('quizzes')->where('id',$id)->get(); 
        //dd($curd);
        if($quiz){
            return response()->json($data = [
            'status' => 200,
            'msg'=>'Show Quiz Data !!',
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
