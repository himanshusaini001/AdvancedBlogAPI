<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\user_role;
use App\Models\User;

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

    // get All  Roles Data
    public function index(){
        try{
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
        catch(\Exception $e)
        {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred Post',
                'error' => $e->getMessage(),
            ]);
        }
    }
    // get Single Role
    public function assignRole(Request $request, User $user) {
        try{
             // Extract user_id from the request
            $user_id = $request->userid;
            $index_id = $request->index_role_id;
            // Validation rules
            $rules = [
                'userid' => 'required|integer|exists:users,id',
            ];
        
            // Validate the request data
            $validator = Validator::make($request->all(), $rules);
        
            // Check for validation errors
            if ($validator->fails()) {
                // Handle the errors, you can return them or perform any other action
                return response()->json(['errors' => $validator->errors()], 400);
            }
        
            if($validator)
            {
                User::where('id', $user_id)->update(['role_id' => $index_id]);
            }
            // Assign the role to the user
            // Implement your logic here to assign the role
        
            // Return success response
            return response()->json(['message' => 'Role assigned successfully'], 200);
        }catch(\Exception $e)
        {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred Post',
                'error' => $e->getMessage(),
            ]);
        }
    }
    


      
     
      

    
    
}
