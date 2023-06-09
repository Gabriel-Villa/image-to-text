<?php

namespace App\Processors;

use App\Access\Image;
use Closure;
use Illuminate\Support\Facades\Process;

class Threshold extends Image
{
    public function __construct(private string $percent)
    {
        parent::__construct();
    }

    public function handle($filename, Closure $next)
    {
        Process::run("convert {$this->imagesPath}/{$filename} -threshold {$this->percent}% {$this->imagesPath}/{$filename}");

        return $next($filename);
    }
}
