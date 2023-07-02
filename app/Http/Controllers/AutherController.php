<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use App\Models\Auther;
use App\Http\Requests\StoreAutherRequest;
use App\Http\Requests\UpdateAutherRequest;
use Illuminate\Http\Request;


class AutherController extends Controller
{
    private function isEmpty($value)
    {
        return $value->count() === 0;
    }

    private function errorResponse($message, $statusCode)
    {
        return response()->json(['data' => $message], $statusCode);
    }

    public function getAllAuthor(Request $request)
    {
        $getAllAuthor = Auther::query()->paginate(5);

        if ($this->isEmpty($getAllAuthor)) {
            return response()->json('Auther collection is empty');
        }
        
        return response()->json(['authors' => $getAllAuthor]);
    }
    public function createAuthor(StoreAutherRequest $request)
    {
        try {
            $validatedData = $request->validated();
            
            $author = new Auther();
            $author->first_name = $request->post('first_name');
            $author->last_name = $request->post('last_name');
            $author->email = $request->post('email');
            $author->password = $request->post('password');
            $author->gender = $request->post('gender');
            $author->image = $request->post('image');
            $author->save();
            
            return response()->json(['message' => 'Author created successfully', 'author' => $author], 201);
        } catch (QueryException $exception) {
            return response()->json(['message' => 'Failed to create author. Missing required field.'], 400);
        }
    }
    
    public function updateAuthor(UpdateAutherRequest $request, $id)
    {
        $author = Auther::find($id);

        if (!$author) {
            return $this->errorResponse('Author not found with ID: ' . $id, 404);
        }

        try {
            $validatedData = $request->validated();

            $author->first_name = $request->post('first_name');
            $author->last_name = $request->post('last_name');
            $author->email = $request->post('email');
            $author->password = $request->post('password');
            $author->gender = $request->post('gender');
            $author->image = $request->post('image');
            $author->save();

            return response()->json(['message' => 'Author updated successfully']);
        } catch (QueryException $exception) {
            return response()->json(['message' => 'Failed to update author. Missing required field.'], 400);
        }
    }

    public function deleteAuthor($id)
    {
        try {
            $author = Auther::find($id);
    
            if (!$author) {
                return $this->errorResponse('Author not found with ID: ' . $id, 404);
            }
    
            $author->delete();
    
            return response()->json(['data' => 'Deleted Author with ID: ' . $id], 200);
        } catch (QueryException $exception) {
            return response()->json(['message' => 'Failed to delete author. It is referenced by other records.'], 400);
        }
    }  
    
}
