<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UrlController;

// Main page
Route::get('/', [UrlController::class, 'index']);

// URL shorten करने के लिए
Route::post('/shorten', [UrlController::class, 'store']);

// Redirect (ये last में रखना जरूरी है)
Route::get('/{shortCode}', [UrlController::class, 'redirect'])
    ->where('shortCode', '[a-zA-Z0-9]+');