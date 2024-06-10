<?php
use App\Http\Controllers\api\HomePage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
<<<<<<< HEAD
use App\Http\Controllers\CommentController;

=======
use App\Http\Controllers\AuthController;

use PHPUnit\Framework\Reorderable;
>>>>>>> c2d5135190ef949fe74f7249f674622eccd17e9e

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


Route::get('/home',[HomePage::class, 'index']);

<<<<<<< HEAD
//Comment route
Route::get('/comments',[CommentController::class, 'index']);
Route::post('/comments',[CommentController::class, 'store']);
Route::get('/comments/{id}',[CommentController::class, 'show']);
Route::put('/comments/{id}',[CommentController::class, 'update']);
Route::delete('/comments/{id}',[CommentController::class, 'destroy']);
=======
// user
Route::post('register/account', [AuthController::class, 'register'])->name('register');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout',[AuthController::class, 'logout'])->middleware('auth:sanctum');
>>>>>>> c2d5135190ef949fe74f7249f674622eccd17e9e
