<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class apiController extends Controller
{
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
            'password'=>$request->password,
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
                'message' => 'An error occurred',
                'error' => $e->getMessage(),
            ]);
        }
    }
}
