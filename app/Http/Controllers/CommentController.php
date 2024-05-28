<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\post;
use App\Models\user;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function index(){
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
