<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class apiController extends Controller
{
    public function register(Request $request)
    {
        try{

        }catch(\Exception $e)
        {
            return response()->json([
                
            ]);
        }
    }
}
