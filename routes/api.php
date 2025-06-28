<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\PageController;
use App\Http\Controllers\API\PartnerController;
use App\Http\Controllers\API\PostController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Authentication Routes
Route::post('/login', [AuthController::class, 'login']);

// Public Routes
Route::get('/pages', [PageController::class, 'index']);
Route::get('/pages/{section}', [PageController::class, 'show']);
Route::get('/pages/{section}/both-languages', [PageController::class, 'showBothLanguages']);

// Public Partner Routes (for contact form)
Route::post('/partners', [PartnerController::class, 'store']);

// Public Post Routes
Route::get('/posts/published', [PostController::class, 'published']);
Route::get('/posts/featured', [PostController::class, 'featured']);
Route::get('/posts/{id}', [PostController::class, 'show'])->where('id', '[0-9]+');

// Protected Routes
Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    Route::put('/user', [AuthController::class, 'updateProfile']);

    // User Management Routes
    Route::apiResource('users', UserController::class);

    // CMS Page Management Routes
    Route::put('/pages/{section}', [PageController::class, 'update']);

    // Partner Management Routes
    Route::get('/partners', [PartnerController::class, 'index']);
    Route::get('/partners/statistics', [PartnerController::class, 'statistics']);
    Route::get('/partners/{id}', [PartnerController::class, 'show']);
    Route::put('/partners/{id}/status', [PartnerController::class, 'updateStatus']);
    Route::delete('/partners/{id}', [PartnerController::class, 'destroy']);

    // Post Management Routes
    Route::get('/posts', [PostController::class, 'index']);
    Route::post('/posts', [PostController::class, 'store']);
    Route::put('/posts/{id}', [PostController::class, 'update']);
    Route::put('/posts/{id}/status', [PostController::class, 'updateStatus']);
    Route::delete('/posts/{id}', [PostController::class, 'destroy']);
    Route::get('/posts/statistics', [PostController::class, 'statistics']);
});
