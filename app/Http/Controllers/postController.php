<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\post;
use App\Models\user;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class postController extends Controller
{
     // Store Post
    public function store(Request $request){
      
        try{

            $user_id = $request->user_id;
            $validation = Validator::make($request->all(), [
                'title' => 'required',
                'content' => 'required',
                'user_id' => 'required|integer|exists:users,id',
            ]);

             // Validation All Data
            if ($validation->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validation->errors()->all(),
                ],401);
            }

            $post = post::create([
                'title'=>$request->title,
                'content'=>$request->content,
                'user_id'=>$request->user_id,
            ]);
            
            return response()->json([
                'status'=>true,
                'message'=>'Successfull Store post Data',
            ],200);
        }catch(\Exception $e)
        {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred Post',
                'error' => $e->getMessage(),
            ]);
        }
    }
    // Create Post
    public function index(){
        try{
            $index = post::all();
            if($index)
            {
                return response()->json([
                    'status' => TRUE,
                    'message' => 'Successfull Get Post Data',
                    'Data' => $index,
                ]);
            }
            else{
                return response()->json([
                    'status' => false,
                    'message' => 'Dose Not Select Data In Post Table',
                ]);
            }
        }
        catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => 'An error occurred Post',
                'error' => $e->getMessage(),
            ]);
        }

    }
     // Show Post
    public function show($id){
        try{
            $show = post::find($id);
            if($show)
            {
                return response()->json([
                    'status' => true,
                    'message' => 'Successfull Get Data With Id',
                    'Data' => $show,
                ]);
            }
            else{
                return response()->json([
                    'status' => false,
                    'message' => 'Dose Not Exist Id Post Table',
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => 'An error occurred Post',
                'error' => $e->getMessage(),
            ]);
        }
    }
     // update Post
     public function update(Request $request, Post $post) {
        try{
            $post_id = $request->post_id;
            // Validation logic
            $validation = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'post_id' => 'required|integer|exists:posts,id',
            ]);
        
            if ($validation->fails()) {
                return response()->json(['errors' => $validation->errors()], 422);
            }
        
            // Update the post with the validated data
            if ($validation) {
                $post->where('id', $post_id)->update([
                    'title' => $request->title,
                    'content' => $request->content,
                ]);
                
                return response()->json(['message' => 'Post updated successfully'], 200);
            } else {
                return response()->json(['message' => 'Post not found'], 404);
            }
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => 'An error occurred Post',
                'error' => $e->getMessage(),
            ]);
        }
    }
    
     // destroy Post
     public function destroy($id, Post $post)
     {
        try
        {
            // Find the post by ID or fail if not found
            $postToDelete = $post->findOrFail($id);
                    
            // Delete the post
            if( $postToDelete->delete())
            {
                // You might want to return a response or redirect after deletion
                return response()->json(['message' => 'Post deleted successfully.'], 200);
            }else{
                echo 'not';die;
            }
       
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => 'Dose Not Exist Id',
                'error' => $e->getMessage(),
            ]);
        }
    }

}
