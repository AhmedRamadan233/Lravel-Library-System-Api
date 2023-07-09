<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Http\Request;
use App\Traits\AuthorizeChecked ;


class CategoryController extends Controller
{
    use  AuthorizeChecked;

    private function isEmpty($value)
    {
        return $value->count() === 0;
    }

   

    // Add any additional logic or data manipulation if needed

    public function getAllCategories(Request $request)
    {

        $this->authorizeChecked('list-category');
        $filters = $request->query();
        $getAllCategories = Category::filter($filters)->paginate();
        if ($this->isEmpty($getAllCategories)) {
            return response()->json('Category collection is empty');
        }
        return response()->json(['authors' => $getAllCategories]);
    }
    public function createCategory(StoreCategoryRequest $request)
    {
        $this->authorizeChecked('add-category');
        $validatedData = $request->validated();
        $category = new Category();
        $category->name = $request->post('name');
        $category->save();
        
        return response()->json(['message' => 'Category created successfully', 'category' => $category], 201);
    }

    public function updateCategory(UpdateCategoryRequest $request, $id)
    {
        $this->authorizeChecked('update-category');
        $category = Category::findOrFail($id);
        $validatedData = $request->validated();
        $category->name = $request->post('name');
        $category->save();
        return response()->json(['message' => 'Category updated successfully']);
    }
    
    public function deleteCategory($id)
    {
        $this->authorizeChecked('delete-category');
        $category = Category::findOrFail($id);
        $category->delete();
        return response()->json(['data' => 'Deleted Category with ID: ' . $id], 200);
    }  
}
