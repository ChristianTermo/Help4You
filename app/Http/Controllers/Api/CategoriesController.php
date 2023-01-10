<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use App\Utils\CustomResponse;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function getCategories()
    {
       /* $categories = Category::all();
        $subCategories = SubCategory::all();

        return response()->json($categories).response()->json($subCategories);*/

        return CustomResponse::getCategories();

    }

    public function CreateCategories(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $category=Category::create([
            'name' => $request->name,
        ]);

        return response()->json($category);
    }

    public function UpdateCategories(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $category->name = request()->input('name');
        $category->save();
        return $category;
    }

    public function DeleteCategories(Category $category)
    {
      
        $category->delete();
        
    }
}
