<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;


use App\Http\Controllers\BookController;
use App\Http\Controllers\AutherController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MemberController;

use App\Http\Controllers\Admin\RolesAndPermissionController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [LoginController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
   
    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });
    
    Route::resource('roles', RolesAndPermissionController::class);

    Route::prefix('books')->group(function () {
        Route::get('/', [BookController::class, 'getAllBooks']);
        Route::post('/', [BookController::class, 'createBook']);
        Route::post('/{book}', [BookController::class, 'updateBook']);
        Route::delete('/{book}', [BookController::class, 'deleteBook']);


    });

    Route::prefix('members')->group(function () {
        Route::get('/', [MemberController::class, 'getAllMembers']);
        Route::post('/', [MemberController::class, 'createMember']);
        Route::post('/{author}', [MemberController::class, 'updateMember']);
        Route::delete('/{author}', [MemberController::class, 'deleteMember']);
    });

    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'getAllCategories']);
        Route::post('/', [CategoryController::class, 'createCategory']);
        Route::post('/{author}', [CategoryController::class, 'updateCategory']);
        Route::delete('/{author}', [CategoryController::class, 'deleteCategory']);
    });

    Route::prefix('authors')->group(function () {
        Route::get('/', [AutherController::class, 'getAllAuthor']);
        Route::post('/', [AutherController::class, 'createAuthor']);
        Route::post('/{author}', [AutherController::class, 'updateAuthor']);
        Route::delete('/{author}', [AutherController::class, 'deleteAuthor']);
    });

    Route::prefix('users')->group(function () {
        Route::get('/', [BookController::class, 'getAllBooks']);
    });

});
