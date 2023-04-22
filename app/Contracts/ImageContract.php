<?php

namespace App\Contracts;

interface ImageContract
{
    public function treatment();

    public function extractText();

    public function output();
}
