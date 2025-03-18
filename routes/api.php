<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestController;

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

Route::post('/auth/sign-in', [AuthController::class, 'login']);
Route::get('/auth/sign-out', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::get('/quests', [QuestController::class, 'index']);
Route::post('/quests', [QuestController::class, 'store']);
Route::delete('/quests', [QuestController::class, 'destroy']);
Route::patch('/quests', [QuestController::class, 'edit']);