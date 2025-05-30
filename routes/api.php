<?php

use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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



Route::prefix('auth')->group(base_path('routes/api/auth.php'));

Route::middleware('auth:sanctum')->get('/user', function (\Illuminate\Http\Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/posts', [PostController::class, 'store']);
    Route::post('/post_image', [\App\Http\Controllers\PostImageController::class, 'store']);
});

