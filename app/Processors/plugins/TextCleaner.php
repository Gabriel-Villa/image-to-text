<?php

namespace App\Processors\plugins;

use App\Access\Image;
use Closure;
use Illuminate\Support\Facades\Process;

class TextCleaner extends Image
{
    public function __construct(private string $values)
    {
        parent::__construct();
    }

    public function handle($filename, Closure $next)
    {
        Process::run("{$this->pluginsPath}/textcleaner  {$this->values} {$this->imagesPath}/{$filename} {$this->imagesPath}/{$filename}");

        return $next($filename);
    }
}
