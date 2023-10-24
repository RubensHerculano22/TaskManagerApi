<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TaskController;
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
            Route::get('tasks/{id}', [TaskController::class, 'show']);
            Route::post('tasks/', [TaskController::class, 'store']);
            Route::put('tasks/{id}', [TaskController::class, 'update']);
            Route::delete('tasks/{id}', [TaskController::class, 'destroy']);
        });
    });
});