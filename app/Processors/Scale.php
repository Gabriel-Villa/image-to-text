<?php

namespace App\Processors;
use App\Access\Image;
use Illuminate\Support\Facades\Process;
use Closure;

class Scale extends Image
{

    public function handler($filename, Closure $next)
    {

        return $next($filename);
    }

}
