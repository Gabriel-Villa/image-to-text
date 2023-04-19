<?php

use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Process;

Route::get('/', function () {
    return inertia('App');
});

Route::post('/save/image', ImageController::class)->name('save.image');

Route::get('/test', function()
{

    $result = Process::run('tesseract --version')->output();

    dd($result);

});
