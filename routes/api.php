<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\Auth\LoginController;

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



Route::post('/login', [LoginController::class, 'login']);


Route::group(['middleware' => ['auth:sanctum']], function (){

    Route::group(['prefix' => 'posts'],function()
    {
        
        Route::get('/search', [PostController::class, 'searchPost']);

        Route::post('/like/{post}', [PostController::class, 'likePost']);
    });

    Route::resource('posts', PostController::class)->only(['store', 'update', 'destroy']);
});

