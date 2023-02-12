<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Utils\CustomResponse;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();

        $data = [
            "categories" => $categories

        ];
        return view('categories.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'category' => 'exists:categories,name'
        ]);

        $category = new Category();
        $father_id = Category::where('name', '=', $request->input('category'))->value('id');

        $category->name = $request->input('name');
        $category->father_id = $father_id;

        $category->save();
       // return $father_id;
         return redirect()->route('categories.index')->with('success', 'Category added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $data = [
            "category" => $category
        ];
        return view('categories.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $data = [
            "category" => $category
        ];
        return view('categories.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|max:100',
            'category' => 'exists:categories,name'
        ]);

        $category = new Category();

        $father_id = Category::where('name', '=', $request->category)->value('id');

        $category->name = $request->input('name');
        $category->father_id = $father_id;

        $category->save();

        return 'ok';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Photo removed successfully');
    }

    public function getCategories()
    {
        return CustomResponse::getCategories();
    }
}
