<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Register;
use App\User;
use App\Auth;
use DB;

class loginController extends Controller
{
    
    // public function login(Request $request)
    // {
    //     $validator=Validator::make($request->all(),[            
    //         'username'=>'required',
    //         'password'=>'required',
    //     ]);
    //     if($validator->fails())
    //     {
    //         return response()->json(['error'=>$validator->errors()->all()], 409);
    //     }

    //     $user =Register::where('username',$request->username)->first();
    //     // print_r($user);
    //     // die();
        
    //     $password=decrypt($user->password);


    //     if($user && $password==$request->password)
    //     {
    //         return response()->json(['user'=>$user]);
    //     }
    //     else
    //     {
            
    //         return response()->json(['error'=>["oops! Something Going Wrong"]], 409);
    //     }
    // }

     /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        // echo "hello"; die;
    	$validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (! $token = auth('api')->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->createNewToken($token);
    }
      /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

     /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userDetails()
    {
        return response()->json(auth('api')->user());
    }

}
