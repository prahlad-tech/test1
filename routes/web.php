<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UrlController;

Route::get('/', [UrlController::class, 'index']);
Route::post('/shorten', [UrlController::class, 'store']);
Route::get('/{shortCode}', [UrlController::class, 'redirect'])
    ->where('shortCode', '[a-zA-Z0-9]+');