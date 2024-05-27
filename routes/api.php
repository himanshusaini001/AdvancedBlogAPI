<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Register
//Route::post("user/register",[ApiController::class,"register"]);


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
