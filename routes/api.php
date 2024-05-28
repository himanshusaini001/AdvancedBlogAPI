<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\apiController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\postController;
use App\Http\Controllers\CommentController;
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
            Route::post("/store",[postController::class,"store"]);
        // Create All post
          Route::get("/index",[postController::class,"index"]);
        // show Psot
          Route::get("/show/{id}", [postController::class,"show"]);
        // update Post
            Route::put("/update",[postController::class,"update"]);
        // destroy Post
            Route::delete("/destroy/{id}",[postController::class,"destroy"]);

        // Comment Route
  
        // store Comment
             Route::post("/comment/store",[CommentController::class,"store"]);
        // Create All post
            Route::get("/comment/index/{post_id}",[CommentController::class,"index"]);
        // show Get
            Route::get("/comment/show/{comment_id}/{post_id}", [CommentController::class,"show"]);
        // update put
            Route::put("/comment/update",[CommentController::class,"update"]);
        // destroy Comment
            Route::delete("/comment/destroy/{id}",[CommentController::class,"destroy"]);


});

// Role Route 

    // Post Role
    Route::post("/createrole",[RoleController::class,"createrole"]);

    // All Auther in Role
    Route::get("/index",[RoleController::class,"index"]);

     // assignRole Role
     Route::Post("/assignRole",[RoleController::class,"assignRole"])->middleware('auth:sanctum');


