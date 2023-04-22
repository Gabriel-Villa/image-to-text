<?php

namespace App\Services;



class FileService
{

    public function __construct(public $file, public string $path) { }

    public function store()
    {
        $path = $this->file->store($this->path);

        return [
            'path' => $path,
            'name' => pathinfo($path)['basename']
        ];
    }

    public function delete()
    {
        unlink(storage_path($this->path));
    }

}
