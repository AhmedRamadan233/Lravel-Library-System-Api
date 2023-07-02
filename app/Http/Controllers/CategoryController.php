<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;


class CategoryController extends Controller
{

    private function isEmpty($value)
    {
        return $value->count() === 0;
    }
    private function errorResponse($message, $statusCode)
    {
        return response()->json(['data' => $message], $statusCode);
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
        try {
            $validatedData = $request->validated();
            $category = new Category();
            $category->name = $request->post('name');
            $category->save();
            
            return response()->json(['message' => 'Category created successfully', 'category' => $category], 201);
        } catch (QueryException $exception) {
            return response()->json(['message' => 'Failed to create category. Missing required field.'], 400);
        }
    }
    

    
    

    public function updateCategory(UpdateCategoryRequest $request, $id)
    {
        try {
            $category = Category::findOrFail($id);
    
            if (!$category) {
                return $this->errorResponse('Category not found with ID: ' . $id, 404);
            }
    
            $validatedData = $request->validated();
            $category->name = $request->post('name');
            $category->save();
    
            return response()->json(['message' => 'Category updated successfully']);
        } catch (QueryException $exception) {
            return response()->json(['message' => 'Failed to update category. Missing required field.'], 400);
        }
    }
    
    public function deleteCategory($id)
    {
        try {
            $category = Category::find($id);
    
            if (!$category) {
                return $this->errorResponse('Category not found with ID: ' . $id, 404);
            }
    
            $category->delete();
    
            return response()->json(['data' => 'Deleted Category with ID: ' . $id], 200);
        } catch (QueryException $exception) {
            return response()->json(['message' => 'Failed to delete category. It is referenced by other records.'], 400);
        }
    }  
}
