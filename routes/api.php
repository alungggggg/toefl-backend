<?php

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QuestController;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\BundlerController;
use Illuminate\Http\Request;

Route::get('/encrypt', function(Request $request) {
    $encrypt = Crypt::encryptString($request->id);
    return response()->json([
        'status' => true,
        'id' => $request->id,
        'encrypt' => $encrypt,
        'decrypt' => Crypt::decryptString($encrypt),
    ]);
});
Route::post('/auth/sign-in', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    
    Route::get('/auth/sign-out', [AuthController::class, 'logout']);
    
    Route::get('/quests', [QuestController::class, 'index']);
    Route::post('/quests', [QuestController::class, 'store']);
    Route::delete('/quests', [QuestController::class, 'destroy']);
    Route::patch('/quests', [QuestController::class, 'edit']);
    
    Route::post('/users', [UserController::class, 'store']);
    Route::get('/users', [UserController::class, 'index']);
    Route::delete('/users', [UserController::class, 'destroy']);    
    Route::patch('/users', [UserController::class, 'edit']);

    Route::get('/exams', [ExamController::class, 'index']);
    Route::post('/exams', [ExamController::class, 'store']);
    Route::delete('/exams', [ExamController::class, 'destroy']);
    Route::patch('/exams', [ExamController::class, 'edit']);

    Route::post('/exams/join', [RoomController::class, 'enterRoom']);
    Route::post('/exams/exit', [RoomController::class, 'exitRoom']);

    Route::get('/score', [ScoreController::class, 'index']);
    Route::post('/score', [ScoreController::class, 'store']);
    Route::patch('/score', [ScoreController::class, 'edit']);
    Route::delete('/score', [ScoreController::class, 'destroy']);

    Route::post('/bundler', [BundlerController::class, 'store']);
    Route::delete('/bundler', [BundlerController::class, 'destroy']);

    Route::get('/user/profile', [AuthController::class, 'profile']);
});


