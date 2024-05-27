<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\apiController;

// Register
Route::post("user/register",[apiController::class,"register"]);

// login
Route::post("user/login",[apiController::class,"login"]);


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
