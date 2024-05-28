<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

   /**
     * @OA\Info(
     *     title="Laravel API",
     *     version="1.0.2",
     *     description="API documentation for the Laravel project"
     * )
     *
     * @OA\Server(
     *     url="http://127.0.0.1:8000/api",
     *     description="API v1"
     * )
     */
class apiController extends Controller
{

    /**
     * @OA\Post(
     *     path="/user/register",
     *     summary="Register a new user",
     *     tags={"User"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", example="john.doe@example.com"),
     *             @OA\Property(property="password", type="string", example="password")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=400, description="Bad Request")
     * )
     */

    // Register function
    public function register(Request $request)
    {
        try{
           // Add Validation Multiap type
           $validation = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
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

 /**
     * @OA\post(
     *     path="/user/login",
     *     summary="User Login",
     *     tags={"User"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="email", type="string", example="john.doe@example.com"),
     *             @OA\Property(property="password", type="string", example="password")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=400, description="Bad Request")
     * )
     */
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

/**
 * @OA\Get(
 *     path="/user/profile",
 *     summary="Your endpoint summary",
 *     description="Your endpoint description",
 *     operationId="yourOperationId",
 *     tags={"User"},
 *     @OA\Parameter(
 *         name="X-CSRF-TOKEN",
 *         in="header",
 *         required=true,
 *         description="Bearer token",
 *         @OA\Schema(
 *             type="string",
 *             example="Bearer"
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="Authorization",
 *         in="header",
 *         required=true,
 *         description="Access token",
 *         @OA\Schema(
 *             type="string",
 *             example="Bearer {access_token}"
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="Content-Type",
 *         in="header",
 *         required=true,
 *         description="Content type",
 *         @OA\Schema(
 *             type="string",
 *             example="application/json"
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="Accept",
 *         in="header",
 *         required=true,
 *         description="Accepted response type",
 *         @OA\Schema(
 *             type="string",
 *             example="application/json"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful response",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="data",
 *                 type="string",
 *                 example="Your response data"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */

    public function profile()
    {
       try{
        $user = auth()->user();
        return response()->json([
         'status'=>true,
         'message'=>'Successfull Fetch data in Profile',
         'data'=>$user
        ]);
 
       }catch(\Exception $e)
       {
           return response()->json([
               'status' => false,
               'message' => 'An error occurred Post',
               'error' => $e->getMessage(),
           ]);
       }
    }

     // User Logout
     public function logout(Request $request)
     {
        try{
            // Get the authenticated user
            $user = $request->user();
                        
            // Revoke all tokens for the user
            $user->tokens()->delete();

            return response()->json(['message' => 'Logged out successfully from all devices'], 200);
        }catch(\Exception $e)
        {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred Post',
                'error' => $e->getMessage(),
            ]);
        }
     }

     // User Role 
     
}
