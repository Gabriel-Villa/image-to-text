<?php

namespace App\Processors;

use App\Access\Image;
use Illuminate\Support\Facades\Process;
use Closure;

class BrightnessContrast extends Image
{
    public function __construct(private string $values)
    {
        parent::__construct();
    }

    public function handle($filename, Closure $next)
    {
        Process::run("convert {$this->imagesPath}/{$filename} -brightness-contrast {$this->values} {$this->imagesPath}/{$filename}");

        return $next($filename);
    }
}
