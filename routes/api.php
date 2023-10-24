<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\Auth\LoginJwtController;

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

Route::prefix('v1')->namespace('Api')->group(function(){

    Route::post('/login', [LoginJwtController::class, 'login'])->name('login');
    Route::get('/logout', [LoginJwtController::class, 'logout'])->name('logout');
    Route::get('/refresh', [LoginJwtController::class, 'refresh'])->name('refresh');

    Route::group(['middleware' => ['jwt.auth']], function(){

        Route::name('tasks.')->group(function(){
            Route::get('tasks/', [TaskController::class, 'index']);
            Route::get('tasks/{id}', [TaskController::class, 'show'])->name('tasksShow');
            Route::post('tasks/', [TaskController::class, 'store']);
            Route::put('tasks/{id}', [TaskController::class, 'update']);
            Route::delete('tasks/{id}', [TaskController::class, 'destroy']);
        });

        Route::name('categories.')->group(function(){
            Route::get('categories/', [CategoryController::class, 'index']);
            Route::get('categories/{id}', [CategoryController::class, 'show'])->name('categoriesShow');
            Route::post('categories/', [CategoryController::class, 'store']);
            Route::put('categories/{id}', [CategoryController::class, 'update']);
            Route::delete('categories/{id}', [CategoryController::class, 'destroy']);
        });

        Route::name('users.')->group(function(){
            Route::get('users/', [UserController::class, 'index']);
            Route::get('users/{id}', [UserController::class, 'show'])->name('usersShow');
            Route::post('users/', [UserController::class, 'store']);
            Route::put('users/{id}', [UserController::class, 'update']);
            Route::delete('users/{id}', [UserController::class, 'destroy']);
        });
    });
});