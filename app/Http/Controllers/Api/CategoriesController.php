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

    public function UpdateCategories(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $category = Category::find($id);
        $category->name = request()->input('name');
        $category->save();
        return $category;
    }

    public function DeleteCategories(Category $category, $id)
    {

        $category = Category::find($id);
        $category->delete();
        
    }
}
