<?php

namespace App\Processors;

use App\Access\Image;
use Illuminate\Support\Facades\Process;

use Closure;

class Crop extends Image
{

    public function __construct(
        private string $width,
        private string $height,
        private string $x_offset,
        private string $y_offset
    )
    {
        parent::__construct();
    }

    public function handle($filename, Closure $next)
    {
        Process::run("convert {$this->imagesPath}/{$filename} -crop {$this->width}x{$this->height}+{$this->x_offset}+{$this->y_offset} {$this->imagesPath}/{$filename}");

        return $next($filename);
    }

}

