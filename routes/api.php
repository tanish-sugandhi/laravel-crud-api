<?php

use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
Route::get('get', [PostController::class, 'index']);
Route::post('store', [PostController::class, 'store']);
Route::get('get/{id}', [PostController::class, 'show']);
Route::put('update/{id}', [PostController::class, 'update']);
Route::delete('delete/{id}', [PostController::class, 'destroy']);
