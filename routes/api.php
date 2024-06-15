<?php

use App\Http\Controllers\api\HomePage;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FriendController;
// use App\Http\Controllers\FriendRequestController;
// use App\Http\Resources\LikeResource;
// use PHPUnit\Framework\Reorderable;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// defult on home page swagger
Route::get('/home', [HomePage::class, 'index']);

//  user routes
Route::get('/user', [UserController::class, 'index']);
Route::get('/user/{id}', [UserController::class, 'show']);
Route::post('/user/create', [UserController::class, 'store']);
Route::put('/user/update/{id}', [UserController::class, 'update']);
Route::delete('/user/delete/{id}', [UserController::class, 'destroy']);


// user login
Route::get('/user/list', [AuthController::class, 'index']);
Route::post('register/account', [AuthController::class, 'register'])->name('register');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('reset/password', [AuthController::class, 'reset']);



// post routes
Route::get('/post', [PostController::class, 'index']);
Route::get('/post/{id}', [PostController::class, 'show']);
Route::post('/post/create', [PostController::class, 'store']);
Route::put('/post/update/{id}', [PostController::class, 'update']);
Route::delete('/post/delete/{id}', [PostController::class, 'destroy']);


//Comment route
Route::get('/comment', [CommentController::class, 'index']);
Route::post('/comment', [CommentController::class, 'store']);
Route::get('/comment/{id}', [CommentController::class, 'show']);
Route::put('/comment/{id}', [CommentController::class, 'update']);
Route::delete('/comment/{id}', [CommentController::class, 'destroy']);


// update users profile
Route::put('update/updateProfile/{id}', [UserController::class, 'updateProile']);

// view users profile
Route::get('user/profile/{id}', [UserController::class, 'showProile']);


//  route likes posts
Route::get('/like', [LikeController::class, 'index']);
Route::put('/like/update/{id}', [LikeController::class, 'update']);
Route::post('/posts/like', [LikeController::class, 'likePost']);
Route::delete('/posts/{id}/unlike', [LikeController::class, 'unlikePost']);


// Route::get('/likes', [LikeController::class, 'index']);
// Route::post('/likes/create', [LikeController::class, 'store']);
// Route::get('user/show/{id}', [AuthController::class, 'show']);
// // update images profile
// Route::post('update/image/{id}', [AuthController::class, 'uploadProfile']);



// Route friend
Route::get('friend/create', [FriendController::class, 'index']);
Route::post('/friend/request', [FriendController::class, 'store']);
Route::post('/friend/accept', [FriendController::class, 'accept']);
Route::get('/friend/requested/{id}', [FriendController::class, 'showAllRequests']);
Route::get('/friend/list/{id}', [FriendController::class, 'showAllFriends']);
Route::delete('/friend/unfriend/{friendId}', [FriendController::class, 'destroy']);
