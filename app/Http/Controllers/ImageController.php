<?php

namespace App\Http\Controllers;

use App\Access\DniBuilder;
use App\Access\ImageBuilder;
use App\Http\Requests\StoreImageRequest;
use App\Services\FileService;
use App\Services\ImageService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Image;

class ImageController extends Controller
{

    private $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function __invoke(StoreImageRequest $request,)
    {
        $imageDetails = $this->fileService->store($request->file('image'), 'public/images');

        $path = Storage::disk('images')->path('') . $imageDetails['name'];

        Image::make($path)->resize(1440, 920)->save();

        $builder = new ImageBuilder();

        $builder->setBuilder(new DniBuilder($imageDetails['name']));

        $output = $builder->process();

        return redirect()->route('home')->with('output', $output);
    }

}
