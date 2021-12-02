<?php

use App\Http\Controllers\PostsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\AuthController;
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

    Route::get('users', [UsersController::class, 'index']);
    Route::get('users/{id}', [UsersController::class, 'show']);
    Route::post('logout', [AuthController::class, 'logout']);
});


// Public Routes
Route::post('/login', [AuthController::class, 'login']); // Need to login before do Protected routes
Route::get('/posts', [PostsController::class, 'index']);
Route::get('/posts/{id}', [PostsController::class, 'show']);
Route::get('/posts/count', [PostsController::class, 'count']);
Route::get('/userposts/{id}', [UsersController::class, 'getPostsByID']);



// Route::get('users/search/{name}', [UsersController::class, 'search']);
