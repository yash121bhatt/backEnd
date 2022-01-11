<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Register;
use Illuminate\Http\Request;
use App\Auth;
use App\User;
use DB;

class registerController extends Controller
{
    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function studentCreate(Request $request)
    {
		// echo "hello"; die;
		// $data=$request->all();
		// echo "<pre>"; print_r($data);die;
        $validator = Validator::make($request->all(), [
			'username' => 'required|between:2,100',
			'password' => 'required|string|min:6',
            'first_name' => 'required|between:2,100',
			'last_name' => 'required|between:2,100',
            'email' => 'required|email|unique:users|max:50',
            'phone' => 'required|min:10|max:10'
        ]);
		if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
		
		$user = User::create([
			'username' => $request->username,
			'password' => bcrypt($request->password),
			'first_name' => $request->first_name,
			'last_name' => $request->last_name,
			'email' => $request->email,
			'phone' =>$request->phone
		]);		
		// dd($user);		
        return response()->json([
            'message' => 'Successfully registered',
            'user' => $user
        ], 201);
    }
}
