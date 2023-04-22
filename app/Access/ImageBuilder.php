<?php

namespace App\Access;

use App\Contracts\ImageContract;

class ImageBuilder
{
    public $builder;

    public function setBuilder(ImageContract $builder)
    {
        $this->builder = $builder;

        return $this;
    }

    public function process()
    {
        $this->builder->treatment();

        $this->builder->extractText();

        return $this->builder->output();
    }
}
