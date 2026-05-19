<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TaskController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// 3 API Endpoints
Route::get('/tasks', [TaskController::class, 'index']);
Route::get('/tasks/{id}', [TaskController::class, 'show']);
Route::post('/tasks', [TaskController::class, 'store']);

// Bonus #6: AI Study Case Endpoints
Route::post('/ai/chat', [\App\Http\Controllers\Api\AiAssistantController::class, 'chatAssistant']);
Route::post('/ai/faq', [\App\Http\Controllers\Api\AiAssistantController::class, 'generateFaq']);
