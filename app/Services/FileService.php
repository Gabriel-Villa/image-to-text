<?php

namespace App\Services;

class FileService
{
    public function __construct(public $file, public string $disk)
    {
    }

    public function store()
    {
        $filename = $this->file->store('', 'images');

        return [
            'name' => $filename,
        ];
    }

    public function delete()
    {
        unlink($this->disk.$this->file);
    }
}
