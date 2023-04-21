<?php

namespace App\Processors;
use App\Access\Image;
use Illuminate\Support\Facades\Process;
use Closure;

class Scale extends Image
{

    public function __construct(public string $percent = '100')
    {
        parent::__construct();
    }

    public function handle($filename, Closure $next)
    {
        Process::run("convert {$this->imagesPath}/{$filename} -scale {$this->percent}% {$this->imagesPath}/{$filename}");

        return $next($filename);
    }

}
