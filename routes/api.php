<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/items', [ItemController::class, 'index']);

Route::prefix('/item')->group( function() {
    Route::post('/store', [ItemController::class, 'store']);
    Route::put('/{id}', [ItemController::class, 'update']);
    Route::delete('/{id}', [ItemController::class, 'destroy']);
});

Route::middleware('auth:api')->group(function(){
    Route::resource('/tasks', TaskController::class);
    
    Route::post('/categories/{category}/tasks', [TaskController::class, 'tasks']);
    Route::resource('/categories', CategoryController::class);
});

Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);