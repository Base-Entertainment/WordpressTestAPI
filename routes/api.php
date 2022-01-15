<?php

use App\Http\Controllers\PostsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Protected routes (Need to be Authanticated before run these API routes)
Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get('me', [UsersController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('users/{id}', [UsersController::class, 'show']);
});


// Public Routes
Route::post('/login', [AuthController::class, 'login'])->name('login'); // Need to login before do Protected routes
Route::get('/posts', [PostsController::class, 'index']);
Route::get('/categories/{id}/posts', [CategoryController::class, 'posts'])->where('id', '[0-9]+');
Route::get('/posts/{id}/suggestions', [PostsController::class, 'suggestions'])->where('id', '[0-9]+');
Route::get('/posts/count', [PostsController::class, 'count']);
Route::get('users', [UsersController::class, 'index']);
Route::get('users/{user}/posts', [UsersController::class, 'userposts']);
Route::get('/posts/{id}', [PostsController::class, 'get']);
Route::get('/userposts/{id}', [UsersController::class, 'getPostsByID']);







// Route::get('users/search/{name}', [UsersController::class, 'search']);
