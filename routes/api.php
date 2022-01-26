<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Like\LikeController;
use App\Http\Controllers\Link\LinkController;
use App\Http\Controllers\Comment\CommentController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Comment\CommentofcommentController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    // Registration
    Route::post('/logout', [UserController::class, 'logout']);
    Route::post('/auth', [UserController::class, 'authinfo']);

    // Add link in the data base route
    Route::post('/links', [LinkController::class, 'store']);

    // ajout d'un commentaire d'ordre 1
    Route::post('/links/{id}', [CommentController::class, 'store']);

    //ajout d'un commentaire d'ordre 2
    Route::post('/comments/{id}', [CommentofcommentController::class, 'store']);
    Route::delete('/commentofcomments/{id}', [CommentofcommentController::class, 'destroy']);

    // ajout d'un like sur un commentaire d'ordre 2
    Route::post('/commentofcomments/{id}', [LikeController::class, 'likeCommentOfComment']);
    // ajout d'un like sur un commentaire d'ordre 1
    Route::post('/comments/{id}', [LikeController::class, 'likeComment']);

    // Route for comments category private
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::put('/categories/{id}', [CategoryController::class, 'update']);
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);
});

// Route for authentication login and logout
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::get('/links', [LinkController::class, 'index']);
Route::get('/links/{id}', [LinkController::class, 'show']);
Route::get('/commentofcomments', [CommentofcommentController::class, 'index']);



// Route for comments category public
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);
