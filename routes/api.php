<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\BookController;

// ✅ Authentication Routes
Route::post('/register', [AuthenticatedSessionController::class, 'register']); // If you added registration
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth:sanctum');

// ✅ Role-Based API Routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/books', [BookController::class, 'index']); // Viewer + Editor + Admin
    Route::post('/books', [BookController::class, 'store'])->middleware('role:editor,admin'); // Editor + Admin
    Route::put('/books/{id}', [BookController::class, 'update'])->middleware('role:editor,admin'); // Editor + Admin
    Route::delete('/books/{id}', [BookController::class, 'destroy'])->middleware('role:admin'); // Only Admin
});
