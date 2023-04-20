<?php

declare(strict_types=1);

namespace App\Access;

use App\Contracts\ImageContract;
use App\Processors\Threshold;
use App\Processors\plugins\ColorBoost as PluginColorBoost;
use App\Processors\Crop;
use App\Processors\GreyScale;
use App\Processors\Custom;
use App\Processors\ImageExtensionConverter;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Process;
use Log;

class DniBuilder extends Image implements ImageContract
{

    public string $filename;
    public string $filenameFormatTiff;

    public function __construct($filename)
    {
        parent::__construct();

        $this->filename = $filename;
        $this->filenameFormatTiff = '';
    }

    public function treatment()
    {

    }

    public function getDates()
    {

    }

    public function getDni()
    {

    }

    public function getPersonalInformation()
    {
        $output = app(Pipeline::class)
            ->send($this->filename)
            ->through([
                ImageExtensionConverter::class,
                GreyScale::class,
                new Crop(width: "1440", height: "920", x_offset: "15", y_offset: "660"),
                new PluginColorBoost(value: "100"),
                new Custom("-brightness-contrast 40x10 -colorspace HSI -alpha off -channel blue -separate +channel"),
                new Threshold("65"),
            ])
            ->thenReturn();

        // $this->fileService->write($output);

    }

    public function getExtraInformation()
    {

    }



    public function output()
    {
        return Process::run("tesseract -l spa {$this->imagesPath}/{$this->filenameFormatTiff} stdout --dpi 300 --psm 3")->output();
    }

}
