<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\user_role;

class RoleController extends Controller
{
    // Create Role
   public function createRole(Request $request){
    try{
        // Add Validation Multiap type
        $validation = Validator::make($request->all(), [
         'role_type' => 'required',
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
     $users = user_role::create([
         'role_type'=>$request->role_type,
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

    // get Single  Role
    public function indexRole(){
        $indexRole = user_role::all();
       
        if($indexRole)
        {
            return response()->json([
                'status'=>true,
                'message'=>'get All index Role',
                'data'=>$indexRole,
            ]);
        }
        else{
            return response()->json([
                'status'=>false,
                'message'=>'Dose Not exist Role',
            ]);
        }
        
    }

}
