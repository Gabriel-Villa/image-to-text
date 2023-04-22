<?php


use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

Artisan::command('clean:directory {path}', function ()
{
    // sail php artisan clean:directory 'public/images'
    Storage::deleteDirectory($this->argument('path'));
});
