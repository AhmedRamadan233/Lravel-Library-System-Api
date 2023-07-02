<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use Illuminate\Http\Request;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\QueryException;

class BookController extends Controller
{
    
    private function isEmpty($value)
    {
        return $value->count() === 0;
    }

    private function errorResponse($message, $statusCode)
    {
        return response()->json(['data' => $message], $statusCode);
    }

    public function getAllBooks(Request $request)
    {
        $allBooks = Book::query()->paginate(5);

        if ($this->isEmpty($allBooks)) {
            return response()->json('Books collection is empty');
        }
        
        return response()->json(['books' => $allBooks]);
    }


    public function createBook(StoreBookRequest $request)
    {
        try {
            $validatedData = $request->validated();
            
            $book = new Book();
            $book->title = $request->post('title');
            $book->author_id = $request->post('author_id');
            $book->publisher = $request->post('publisher');
            $book->publishing_date = $request->post('publishing_date');
            $book->category_id = $request->post('category_id');
            $book->edition = $request->post('edition');
            $book->pages = $request->post('pages');
            $book->num_of_copies = $request->post('num_of_copies');
            $book->available = $request->post('available');
            $book->shelf_num = $request->post('shelf_num');
            $book->num_of_borrowing = $request->post('num_of_borrowing');
            $book->num_of_reading = $request->post('num_of_reading');
            $book->image = $request->post('image');
            $book->save();
            
            return response()->json(['message' => 'Book created successfully', 'book' => $book], 201);
        } catch (QueryException $exception) {
            return response()->json(['message' => 'Failed to create book. Missing required field.'], 400);
        }
    }




    public function updateBook(UpdateBookRequest $request, $id)
    {
        try {
            $book = Book::find($id);
            
            if (!$book) {
                return $this->errorResponse('Book not found with ID: '.$id, 404);
            }
            
            $validatedData = $request->validated();
            $book->title = $request->post('title');
            $book->author_id = $request->post('author_id');
            $book->publisher = $request->post('publisher');
            $book->publishing_date = $request->post('publishing_date');
            $book->category_id = $request->post('category_id');
            $book->edition = $request->post('edition');
            $book->pages = $request->post('pages');
            $book->num_of_copies = $request->post('num_of_copies');
            $book->available = $request->post('available');
            $book->shelf_num = $request->post('shelf_num');
            $book->num_of_borrowing = $request->post('num_of_borrowing');
            $book->num_of_reading = $request->post('num_of_reading');
            $book->image = $request->post('image');
            $book->save();
            
            return response()->json(['message' => 'Book updated successfully']);
        } catch (QueryException $exception) {
            return response()->json(['message' => 'Failed to update book. Missing required field.'], 400);
        }
    }
    
    
    public function deleteBook($id)
    {
        try {
            $book = Book::find($id);
    
            if (!$book) {
                return $this->errorResponse('Book not found with ID: '.$id, 404);
            }
    
            $book->delete();
    
            return response()->json(['data' => 'Deleted book with ID: '.$id], 200);
        } catch (QueryException $exception) {
            return response()->json(['message' => 'Failed to delete book.'], 500);
        }
    }
    



    
}
