<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class apiController extends Controller
{
    // Register function
    public function register(Request $request)
    {
        try{
           // Add Validation Multiap type
           $validation = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'role_id' => 'required',
        ]);

        // Validation All Data
        if ($validation->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validation->errors()->all(),
            ],401);
        }
        
        //Response Data in Json
        $users = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password' => Hash::make($request->password),
            'role_id'=>$request->role_id,
            
        ]);


        //Response Data in Json
        return response()->json([
            'status' => true,
            'message' => 'User created successfully',
        ],200);

        }catch(\Exception $e)
        {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred Register',
                'error' => $e->getMessage(),
            ]);
        }
    }

    // User Login

   public function login(Request $request)
    {
        try{

            $validation = Validator::make($request->all(), [
                'email'=> 'required|email',
                'password'=> 'required',
            ]);
            if($validation->fails())
            {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validation->errors()->all(),
                ],401);
            }
            if(!Auth::attempt($request->only('email','password')))
            {
                return response()->json([
                    'status' => false,
                    'message' => 'Emial & password Dose not match With Out record.',
                ],401);
            }
            $user = User::Where('email',$request->email)->first();
            return response()->json([
                'status' => true,
                'message' => 'User login is successfully',
                'token' => $user->createToken('Api Token')->plainTextToken,
            ], 200);

        }catch(\Exception $e)
        {
            return response()->json([
                'ststus'=>false,
                'message' => 'An error occurred in Login',
                'error' => $e->getMessage(),
            ]);
        }
    }

    // User Profile

    public function profile()
    {
       $user = auth()->user();
       return response()->json([
        'status'=>true,
        'message'=>'Successfull Fetch data in Profile',
        'data'=>$user
       ]);

    }

     // User Logout
     public function logout(Request $request)
     {
          // Get the authenticated user
            $user = $request->user();
            
            // Revoke all tokens for the user
            $user->tokens()->delete();
            
            return response()->json(['message' => 'Logged out successfully from all devices'], 200);
     }

     // User Role 
     
}
