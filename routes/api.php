<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\QuestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExamController;

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
Route::post('/auth/sign-in', [AuthController::class, 'login']);

Route::get('/quests/{type}', [QuestController::class, 'getByType']);


// utility routes
Route::middleware('auth:sanctum')->group(function () {
    
    Route::get('/auth/sign-out', [AuthController::class, 'logout']);

    Route::get('/quests', [QuestController::class, 'index']);
    Route::post('/quests', [QuestController::class, 'store']);
    Route::delete('/quests', [QuestController::class, 'destroy']);
    Route::patch('/quests', [QuestController::class, 'edit']);

    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store']);
    Route::delete('/users', [UserController::class, 'destroy']);    
    Route::patch('/users', [UserController::class, 'edit']);

    Route::get('/exams', [ExamController::class, 'index']);
    Route::post('/exams', [ExamController::class, 'store']);
    Route::delete('/exams', [ExamController::class, 'destroy']);
    Route::patch('/exams', [ExamController::class, 'edit']);
});


