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
        $imageDetails = (new FileService(file: $request->file('image'), path: 'public/images'))->store();

        $builder = new ImageBuilder();

        $output = $builder->setBuilder(new DniBuilder($imageDetails['name']))->process();

        return redirect()->route('home')->with('output', $output);
    }
}
