<?php


use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

Artisan::command('clean:directory {directory}', function ()
{
    Storage::disk($this->argument('directory'))->deleteDirectory('');

    return 0;
});
