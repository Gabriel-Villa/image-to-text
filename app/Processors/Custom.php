<?php

namespace App\Processors;

use App\Access\Image;
use Closure;
use Illuminate\Support\Facades\Process;

class Custom extends Image
{
    public function __construct(private string $command)
    {
        parent::__construct();
    }

    public function handle($filename, Closure $next)
    {
        Process::run("convert {$this->imagesPath}/{$filename} {$this->command} {$this->imagesPath}/{$filename}");

        return $next($filename);
    }
}
