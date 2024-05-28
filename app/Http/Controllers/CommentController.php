<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\post;
use App\Models\comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    // All Data show
    public function index($post_id){
        try{
            $count = comment::where('post_id',$post_id)->count();
            if($count > 0 )
            {
                $show = comment::where('post_id',$post_id)->get();
                return response()->json([
                    'status' => true,
                    'message' => 'Successfull Get Data With Id',
                    'Data' => $show,
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
    //Create Data in comment
    public function store(Request $request, Post $post) {
        try {
            // Get the user ID from the request
            $user_id = $request->user_id;
    
            // Validate the incoming request data
            $validation = Validator::make($request->all(), [
                'comment' => 'required', // Ensure that 'content' is a required field
                'user_id' => 'required|integer|exists:users,id',
            ]);
    
            // Check if the validation fails
            if ($validation->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validation->errors()->all(),
                ], 401);
            }
            
            $post_id = post::where('user_id',$user_id)->pluck('id');
            if($post_id)
            {
                // Create a new comment
                $comment = comment::create([
                    'comment' => $request->comment,
                    'user_id' => $request->user_id,
                    'post_id' => $post_id[0],
                ]);

                // Return a success response
                return response()->json([
                    'status' => true,
                    'message' => 'Successfully stored comment data',
                    'Data'=>$comment,
                ], 200);
            }
          
        } catch (\Exception $e) {
            // Catch any exceptions and return an error response
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while storing the comment',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    //show Data in comment
    public function show(Post $post, comment $comment,$comment_id,$post_id){
        try{
            $count = comment::with('post_id',$post_id)->where('id',$comment_id)->count();
            if($count > 0)
            {
                $comment = Comment::where('post_id', $post_id)->where('id', $comment_id)->get();
                return response()->json([
                    'status' => true,
                    'message' => 'comments',
                    'data' => $comment
                ],200);
            }
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => 'An error occurred Post',
                'error' => $e->getMessage(),
            ]);
        }
    }

    //update Data in comment
    public function update(Request $request, Post $post, comment $comment)
    {
        try{
            $post_id= $request->post_id;
            $comment_id= $request->comment_id;
            $validate_request= $request->validate([
                'comment' => 'required|string|max:255',
                'comment_id' => 'required|integer|exists:comments,id',
                'post_id' => 'required|integer|exists:comments,post_id',
            ]);
    
            if($validate_request)
            {
                $count = Comment::where('post_id', $post_id)->where('id', $comment_id)->count();
                if($count > 0)
                {
                $comment = Comment::where('post_id', $post_id) ->where('id', $comment_id)->update(['comment' => $request->comment]);           
                    return response()->json([
                    'status' => true,
                    'message' => 'update successfuly',
                    ],200);
                }
                else{
                    return response()->json([
                    'status' => false,
                    'message' => 'invalid user',
                    'data' => []
                    ],200);
                }
            }
        }catch(\Exception $e)
        {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred Post',
                'error' => $e->getMessage(),
            ]);
        }
    } 
    //destroy Data in comment
    public function destroy(){
        try{

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

    
}
