<?php

namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Restaurant;
use App\Traits\ImageUploader;


class CategoryController extends Controller
{
    use ImageUploader;


    /**
     * Display a list of all Categories.
     */
    public function index(Restaurant $restaurant)
    {
         $categories = Category::where('restaurant_id', $restaurant->id)->get();

         return response()->json($categories);
    }



    /**
     * create a new category related to a specific restaurant.
     */
    public function store(StoreCategoryRequest $request, Restaurant $restaurant)
    {
      $category = $restaurant->categories()->create($request->safe()->except('image'));

      if ($request->hasFile('image'))
      {

      $url = $this->uploadImage($request->file('image'), 'categories');

      return response()->json([
         'msg' => 'category add successfully',
         'category'=> $category,
         'category_image' => $url,
      ]);

     }
    }


    /**
     * Display a specific category for a specific restaurant.
     */
    public function show(Restaurant $restaurant,Category $category)
    {
         abort_if($restaurant->id != $category->restaurant->id, 404); // Not found

         return response()->json([
            'category_name' => $category->name,
            'category_id' => $category->id,
            'restaurant_id' => $restaurant->id
         ]);
    }




    /**
     * Update a specific category related to a specific restaurant.
     */
    public function update(UpdateCategoryRequest $request, Restaurant $restaurant,Category $category)
    {
        $category->update($request->safe()->except('image'));

        return response()->json([
            'msg' => 'Category updated successfully.',
            'category_name' => $category->name,
            'category_id' => $category->id,
            'restaurant_id' => $restaurant->id
         ]);
    }

    /**
     * Delete a specific category related to a specific restaurant.
     */
    public function destroy(Restaurant $restaurant,Category $category)
    {

        abort_if($restaurant->id != $category->restaurant->id, 404); // Not found

        $category->delete();

        return response()->json([
         'msg' => 'Category deleted successfully',
         'deleted_at' => $category['deleted_at']
      ]);
    }
 }

