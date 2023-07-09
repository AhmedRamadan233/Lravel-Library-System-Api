<?php

namespace App\Http\Controllers;

use App\Models\Auther;
use App\Http\Requests\StoreAutherRequest;
use App\Http\Requests\UpdateAutherRequest;
use Illuminate\Http\Request;
use App\Traits\ImageProcessing;
use App\Traits\AuthorizeChecked ;

class AutherController extends Controller
{
    use ImageProcessing , AuthorizeChecked;

    private function isEmpty($value)
    {
        return $value->count() === 0;
    }

    public function getAllAuthor(Request $request)
    {
        $this->authorizeChecked('list-author');
        $filters = $request->query();

        $getAllAuthor = Auther::filter($filters)->paginate();

        if ($this->isEmpty($getAllAuthor)) {
            return response()->json('Auther collection is empty');
        }
        
        return response()->json(['authors' => $getAllAuthor]);
    }
    public function createAuthor(StoreAutherRequest $request)
    {
        $this->authorizeChecked('add-author');
        $validatedData = $request->validated();
        $imagePath = $this->saveImage($request->file('image'));
        $author = new Auther();
        $author->first_name = $request->post('first_name');
        $author->last_name = $request->post('last_name');
        $author->email = $request->post('email');
        $author->password = $request->post('password');
        $author->gender = $request->post('gender');
        $author->image = $imagePath;
        $author->save();
        $author->image_url = asset('imagesfp/authors/' . $author->image);
        return response()->json(['message' => 'Author created successfully', 'author' => $author], 201);
    }
    
    public function updateAuthor(UpdateAutherRequest $request, $id)
    {
        $this->authorizeChecked('update-author');
        $author = Auther::findOrFail($id);
        $validatedData = $request->validated();
        $author->first_name = $request->post('first_name');
        $author->last_name = $request->post('last_name');
        $author->email = $request->post('email');
        $author->password = $request->post('password');
        $author->gender = $request->post('gender');
        if ($request->hasFile('image')) {
            if ($author->image) {
                $this->deleteImage($author->image); // Delete old image
            }
    
            $imagePath = $this->saveImage($request->file('image')); // Save new image
            $author->image = $imagePath;
        }            
        $author->save();
        $author->image_url = asset('imagesfp/authors/' . $author->image);
        return response()->json(['message' => 'Author updated successfully', 'author' => $author], 200);
    }

    public function deleteAuthor($id)
    {
        $this->authorizeChecked('delete-author');
        $author = Auther::findOrFail($id);
        if ($author->image) {
            $this->deleteImage($author->image); // Delete the associated image
        }
        $author->delete();
        return response()->json(['data' => 'Deleted Author with ID: ' . $id], 200);
        
    }  
    
}
