<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use DB;

class QestionControlle extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    //add_quiz
    public function addQuestion(Request $request)
    {
		// echo "hello"; die;
		// $data=$request->all();
		// echo "<pre>"; print_r($data);die;
        $validator = Validator::make($request->all(), [
			'content' => 'required|between:2,100',
            'option1' => 'required|string', 
            'option2' => 'required|string',
            'option3' => 'required|string',
            'option4' => 'required|string',
            'answer' => 'required|string',
            'quizId' => 'required|numeric',
        ]);
		if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
		
        $url="http://127.0.0.1:8000/public/upload/";
        // $file=$request->file('image');
        // $extension=$file->getClientOriginalExtension();
        //  dd($extension);
        // exit;
        // $path=$request->file('image')->storeAs('question', $request->id.'.'.$extension);
        if($request->image){

            $imageName = time().'.'.$request->image->extension();  
   
            $request->image->move(public_path('question'), $imageName);
            $image_path=public_path('question/').$imageName;
            // dd($path);

        }
        else{
            $imageName = null;
            $image_path = null; 
        }
       
        // exit;
        //   $image_name=$path;
        //   $image_path=$url.$path;

		$ques = DB::table('questions')->insert([
			'content' => $request->content,
            'image_name' =>$imageName,
            'image_path' =>$image_path,
			'option1' => $request->option1,
            'option2' => $request->option2,
            'option3' => $request->option3,
            'option4' => $request->option4,
            'answer' => $request->answer,
            'quiz_id' => $request->quizId,
		]);		
		// dd($user);		
        return response()->json([
            'message' => 'Questions Successfully added',
            'response' => $ques
        ], 201);
    }

    //list_quiz
    public function listQuestion($quizId){

        // $ques = DB::table('questions')->get();
        $ques = DB::table('questions')->where('quiz_id',$quizId)->get();
		// dd($user);		
        return response()->json([
            'message' => 'Quiz List !!',
            'response' => $ques
        ], 201);
    }

    public function deleteQuestion($id){ //obj model ka Curd

        $ques =DB::table('questions')->delete($id);
           
        //dd($curd);
        if($ques){
            return response()->json($data = [
            'status' => 200,
            'msg'=>'Question Delete Successfully !!',
            'response' => $ques
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
     public function updateQuestion(Request $request,$id=null){ //obj model ka Curd
        // return  response($request);
        // dd($request->all());
        // die;
        $validator = Validator::make($request->all(), [
			'content' => 'required|between:2,100',
            'option1' => 'required|string', 
            'option2' => 'required|string',
            'option3' => 'required|string',
            'option4' => 'required|string',
            'answer' => 'required|string',
            'quiz_id' => 'required|numeric',
        ]);
		if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $url="http://127.0.0.1:8000/public/upload/";
        if($request->image){
        $imageName = time().'.'.$request->image->extension();  
        $request->image->move(public_path('question'), $imageName);
        $image_path=public_path('question/').$imageName;
        }
        else{
            $imageName = null;
            $image_path = null; 
        }
       
    
        $ques =DB::table('questions')->where('id', $id)->update([
             
            'content' => $request->content,
            'image_name' =>$imageName,
            'image_path' =>$image_path,
			'option1' => $request->option1,
            'option2' => $request->option2,
            'option3' => $request->option3,
            'option4' => $request->option4,
            'answer' => $request->answer,
            'quiz_id' => $request->quiz_id,
        ]);
           
        //dd($curd);
        if($ques){
            return response()->json($data = [
            'status' => 200,
            'msg'=>' Questions Update Successfully !!',
            'response' => $ques
            ]);
        }
        else{
            return response()->json($data = [
            'status' => 201,
            'msg' => 'Data Not Found'
            ]);
        }

    
     }
     //get Question
     public function getQuestion($id){ //obj model ka Curd

        $ques =DB::table('questions')->where('id',$id)->get();
           
        // dd($ques);
        if($ques){
            return response()->json($data = [
            'status' => 200,
            'msg'=>'Show Question Data !!',
            'response' => $ques
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
