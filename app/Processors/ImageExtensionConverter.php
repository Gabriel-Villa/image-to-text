<?php

namespace App\Processors;

use App\Access\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Process;
use Closure;
use Log;

class ImageExtensionConverter extends Image
{

    public function __construct()
    {
        parent::__construct();
    }

    public function handle($filename, Closure $next)
    {
        $imageFormatTiff = pathinfo($filename)['filename'].".tiff";

        Process::run("convert {$this->imagesPath}/{$filename} {$this->imagesPath}/{$imageFormatTiff}");

        return $next($imageFormatTiff);
    }

}
