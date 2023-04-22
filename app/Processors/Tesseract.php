<?php

namespace App\Processors;

use App\Access\Image;
use Closure;
use Illuminate\Support\Facades\Process;

class Tesseract extends Image
{
    public function __construct()
    {
        parent::__construct();
    }

    public function handle($filename, Closure $next)
    {
        $result = Process::run("tesseract -l spa {$this->imagesPath}/{$filename} stdout --dpi 300 --psm 3")->output();

        return $next($result);
    }
}
