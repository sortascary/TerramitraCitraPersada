<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\v1\AuthController;
use App\Http\Controllers\v1\PageController;
use App\Http\Controllers\v1\ChatController;
use App\Http\Controllers\v1\DashboardController;

Route::post('/login', [AuthController::class, 'loginApi']);
Route::post('/register', [AuthController::class, 'registerApi']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::post('comment/{id}', [PageController::class, 'createCommentApi'])->middleware('auth:sanctum');
Route::prefix('dashboard')->group(function () {

    Route::prefix('Blog')->group(function () {
        Route::get('getBlog', [DashboardController::class, 'CreateBlog']);
        Route::post('addBlog', [DashboardController::class, 'CreateBlog']);
        Route::post('UpdateBlog', [DashboardController::class, 'CreateBlog']);
        Route::delete('DeleteBlog/{id}', [DashboardController::class, 'CreateBlog']);
    });

    Route::prefix('Client')->group(function () {
        Route::get('getClient', [DashboardController::class, 'getClient']);
        Route::post('addClient', [DashboardController::class, 'CreateClient']);
        Route::post('UpdateClient/{id}', [DashboardController::class, 'UpdateClientApi']);
        Route::delete('DeleteClient/{id}', [DashboardController::class, 'DeleteClient']);
    });

});

Route::prefix('Forum')->group(function () {
    Route::get('/get', [ChatController::class, 'getChats'])->middleware('auth');
    // Route::get('getForum', [ChatController::class, 'getChats'])->middleware('auth:sanctum');
    Route::post('addForum', [DashboardController::class, 'CreateForum']);
    Route::delete('DeleteForum/{id}', [DashboardController::class, 'CreateForum']);
});

Route::prefix('Messages')->group(function () {
    Route::get('getMessages/{id}', [ChatController::class, 'getMessages'])->middleware('auth:sanctum');
    Route::post('addMessages', [DashboardController::class, 'Create']);
    Route::delete('DeleteMessages', [DashboardController::class, 'Create']);
});

Route::prefix('Comment')->group(function () {
    Route::get('getComment', [DashboardController::class, 'Create']);
    Route::post('addComment', [DashboardController::class, 'Create']);
    Route::delete('DeleteComment/{id}', [DashboardController::class, 'Create']);
});
