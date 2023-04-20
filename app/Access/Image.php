<?php

namespace App\Access;

abstract class Image
{

    public string $imagesPath;
    public string $pluginsPath;

    public function __construct()
    {
        $this->imagesPath = config('paths.imagesPath');
        $this->pluginsPath = config('paths.pluginsPath');
    }

}
