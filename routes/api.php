<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\apiController;

// Register
Route::post("/user/register",[apiController::class,"register"]);

// login
Route::post("/user/login",[apiController::class,"login"]);

// user Route
Route::group(['prefix' => 'user', 'middleware' => ['auth:sanctum']], function () {

    // profile
    Route::get("/profile",[apiController::class,"profile"]);   

     // Logout
     Route::delete("/logout",[apiController::class,"logout"]);   
});


Route::group(['prefix' => 'user', 'middleware' => ['auth:sanctum']], function () {

    // profile
    Route::get("/profile",[apiController::class,"profile"]);   

     // Logout
     Route::delete("/logout",[apiController::class,"logout"]);   
});
