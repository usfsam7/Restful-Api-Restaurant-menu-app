<?php



use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\LoginController;
use App\Http\Controllers\Api\V1\LogoutController;
use App\Http\Controllers\Api\V1\RegisterController;
use App\Http\Controllers\Api\V1\RestaurantController;




 Route::middleware('auth:sanctum')->prefix('v1')->group(function()
 {
    // logout route
    Route::post('logout', LogoutController::class);


    // Restaurant routes
    Route::prefix('restaurant')->group(function()
    {
        // add a new restaurant
     Route::post('add', [RestaurantController::class, 'store']);

        // get all restaurants
     Route::get('list', [RestaurantController::class, 'index']);

        // get a specific restaurant with id
     Route::get('{restaurant}', [RestaurantController::class, 'show']);

       // update a specific restaurant
     Route::post('{restaurant}', [RestaurantController::class, 'update']);

       // delete a specific restaurant
     Route::delete('{restaurant}', [RestaurantController::class, 'destroy']);


     // Category routes
     Route::prefix('{restaurant}/category')->group(function()
     {
        // add a new category for a specific restaurant
        Route::post('add', [CategoryController::class,'store']);

        // get all categories for a specific restaurant
        Route::get('list', [CategoryController::class,'index']);

       // get a specific category for a specific restaurant.
        Route::get('{category}', [CategoryController::class,'show']);

       // Update a specific category related to a specific restaurant.
        Route::post('update/{category}', [CategoryController::class,'update']);

        // Delete a specific category related to a specific restaurant.
        Route::delete('delete/{category}', [CategoryController::class,'destroy']);
     }
    );

    });
 }
);




// Authentication Routes (Registration, Login)
Route::middleware('guest:sanctum')->prefix('v1')->group( function()
  {
       // registration route
      Route::post('register', RegisterController::class);

      //login route
      Route::post('login', LoginController::class);
  }
);



