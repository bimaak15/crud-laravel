<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KonserController;
use App\Http\Controllers\PemesananController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::get('/konser', [KonserController::class, 'index']);
Route::get('/konser/{id}', [KonserController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::post('/pemesanan', [PemesananController::class, 'store']);
    Route::get('/pemesanan', [PemesananController::class, 'index']);
    Route::post('/pemesanan/{id}', [PemesananController::class, 'update']);
    Route::delete('/pemesanan/{id}', [PemesananController::class, 'destroy']);
});