<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Http\Request;


class CategoryController extends Controller
{

    private function isEmpty($value)
    {
        return $value->count() === 0;
    }
    public function getAllCategories(Request $request)
    {
        $getAllCategories = Category::query()->paginate(5);
        if ($this->isEmpty($getAllCategories)) {
            return response()->json('Category collection is empty');
        }
        return response()->json(['authors' => $getAllCategories]);
    }
    public function createCategory(StoreCategoryRequest $request)
    {
        $validatedData = $request->validated();
        $category = new Category();
        $category->name = $request->post('name');
        $category->save();
        
        return response()->json(['message' => 'Category created successfully', 'category' => $category], 201);
    }

    public function updateCategory(UpdateCategoryRequest $request, $id)
    {
        $category = Category::findOrFail($id);
        $validatedData = $request->validated();
        $category->name = $request->post('name');
        $category->save();
        return response()->json(['message' => 'Category updated successfully']);
    }
    
    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return response()->json(['data' => 'Deleted Category with ID: ' . $id], 200);
    }  
}
