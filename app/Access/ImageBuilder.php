<?php

namespace App\Access;

use App\Contracts\ImageContract;

class ImageBuilder
{
    public $builder;

    public function setBuilder(ImageContract $builder)
    {
        $this->builder = $builder;
    }

    public function process()
    {
        $this->builder->treatment();

        return $this->builder->output();
    }
}
