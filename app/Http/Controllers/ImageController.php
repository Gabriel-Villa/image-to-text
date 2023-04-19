<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreImageRequest;
use Illuminate\Http\Request;

class ImageController extends Controller
{

    public function __invoke(StoreImageRequest $request)
    {
        $fileName = $request->file('cropped_picture')->store('test');

        $path = storage_path()."/app/".$fileName;

        Image::make($path)->resize(1440, 920)->save();

    }

}
