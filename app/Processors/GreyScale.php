<?php

namespace App\Processors;

use App\Access\Image;
use Closure;
use Illuminate\Support\Facades\Process;

class GreyScale extends Image
{
    public function __construct(private string $color = 'gray')
    {
        parent::__construct();
    }

    public function handle($filename, Closure $next)
    {
        Process::run("convert {$this->imagesPath}/{$filename} -colorspace {$this->color} {$this->imagesPath}/{$filename}");

        return $next($filename);
    }
}
