<?php

namespace App\Processors\plugins;
use App\Access\Image;
use Illuminate\Support\Facades\Process;
use Closure;


class ColorBoost extends Image
{

    public function __construct(private string $value)
    {
        parent::__construct();
    }

    public function handle($filename, Closure $next)
    {
        Process::run("{$this->pluginsPath}/colorboost  -f {$this->value} {$this->imagesPath}/{$filename} {$this->imagesPath}/{$filename}");

        return $next($filename);
    }

}
