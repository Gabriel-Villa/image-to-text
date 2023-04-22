<?php

use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return inertia('App');
})
->name('home');

Route::post('/image/store', ImageController::class)->name('image.store');
