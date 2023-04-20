<?php

namespace App\Services;

use App\Contracts\FileContract;

class FileService implements FileContract
{

    public function store($file, $directory)
    {
        $path = $file->store($directory);

        return [
            'path' => $path,
            'name' => pathinfo($path)['basename']
        ];
    }

}
