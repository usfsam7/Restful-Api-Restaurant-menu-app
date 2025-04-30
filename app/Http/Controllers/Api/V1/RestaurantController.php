<?php

namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Http\Requests\StoreRestaurantRequest;
use App\Http\Requests\UpdateRestaurantRequest;
use App\Traits\ImageUpload;

class RestaurantController extends Controller
{
    // our trait for handling image uploading.
    use ImageUpload;
    /**
        * Listing all restaurants in the database.
     */
    public function index()
    {
         $restaurants = Restaurant::select('name', 'user_id')->where('user_id', auth()->user()->id)->get();

         return response()->json($restaurants);
    }



    /**
     * Add a new restaurant
     */
    public function store(StoreRestaurantRequest $request)
    {
        $validated = $request->validated();

        $exists = Restaurant::where('user_id', auth()->id())
        ->where('name', $validated['name']) // or any unique field(s) you want to check
        ->exists();

        if ($exists) {
           return response()->json([
              'msg' => 'You have already added this restaurant.'
          ], 409); // 409 Conflict
        }

        $restaurant = Restaurant::create(array_merge($request->safe()->except('image'), ['user_id'=> auth()->id()]));

        if ($request->hasFile('image'))
        {
        //  $url = $request->file('image')->storePublicly('restaurants', ['disk'=>'public']);
        //  $restaurant->image()->create([
        //     'url'=> $url
        //  ]);
        $url = $this->uploadImage($request->file('image'), 'restaurants');
        $restaurant->image()->create([
            'url' => $url,
        ]);

        }

        return response()->json([
           'msg' => 'Success operation',
          'restaurant' => $restaurant
        ]);
    }

    /**
     * Get a specified restaurant.
     */
    public function show(Restaurant $restaurant)
    {
        return response()->json($restaurant);
    }



    /**
     * Update a specified restaurant.
     */
    public function update(UpdateRestaurantRequest $request, Restaurant $restaurant)
    {
          $restaurant->update($request->validated());

          return response()->json([
            'msg' => 'Restaurant updated successfully',
           'restaurant' => $restaurant
         ]);
    }


    /**
     * Remove a  specified restaurant.
     */
    public function destroy(Restaurant $restaurant)
    {
        abort_if($restaurant->user_id != auth()->user()->id,403, 'Unauthorized Action');

        $restaurant->delete();

        return response()->json([
            'msg' => 'Restaurant deleted successfully',
            'deleted_at' => $restaurant['deleted_at']
         ]);
    }
}
