<?php

namespace App\Http\Controllers;

use App\Access\DniBuilder;
use App\Access\ImageBuilder;
use App\Http\Requests\StoreImageRequest;
use App\Services\FileService;
use Image;

class ImageController extends Controller
{
    public function __invoke(StoreImageRequest $request)
    {
        $fileService = new FileService(file: $request->file('image'), path: 'public/images');

        $imageDetails = $fileService->store();

        $path = storage_path().'/app/public/images/'.$imageDetails['name'];

        Image::make($path)->resize(1440, 920)->save();

        $builder = new ImageBuilder();

        $builder->setBuilder(new DniBuilder($imageDetails['name']));

        $output = $builder->process();

        return redirect()->route('home')->with('output', $output);
    }
}
