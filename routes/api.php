<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\apiController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\postController;
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

    // Post Route
        
        // store Post
            Route::post("/store",[apiController::class,"store"]);
        // Create All post
          Route::get("/createPost",[apiController::class,"createPost"]);
        // show Get
            Route::get("/show",[apiController::class,"show"]);
        // update put
            Route::put("/update",[apiController::class,"update"]);
        // destroy Delete
            Route::delete("/destroy",[apiController::class,"destroy"]);


});

// Role Route 

    // Post Role
    Route::post("/createrole",[RoleController::class,"createrole"]);

    // All Auther in Role
    Route::get("/index",[RoleController::class,"index"]);

     // assignRole Role
     Route::Post("/assignRole",[RoleController::class,"assignRole"])->middleware('auth:sanctum');


