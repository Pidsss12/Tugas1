<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TaskController;

Route::get('/', [TaskController::class, 'index'])->name('tasks.index');
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.status');
Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');

// PDF Download Route
Route::get('/tasks/report/download', [TaskController::class, 'downloadReport'])->name('tasks.report');

// View/Download Certificate Route
Route::get('/tasks/{task}/certificate', [TaskController::class, 'showCertificate'])->name('tasks.certificate');

// AI Chat Web Route
Route::post('/ai/web-chat', [\App\Http\Controllers\Api\AiAssistantController::class, 'webChat'])->name('ai.webChat');
