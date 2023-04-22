<?php

namespace App\Processors;

use App\Access\Image;
use Closure;
use Illuminate\Support\Facades\Process;

class ImageExtensionConverter extends Image
{
    public function __construct()
    {
        parent::__construct();
    }

    public function handle($filename, Closure $next)
    {
        $imageFormatTiff = pathinfo($filename)['filename'].'.tiff';

        Process::run("convert {$this->imagesPath}/{$filename} {$this->imagesPath}/{$imageFormatTiff}");

        return $next($imageFormatTiff);
    }
}
