<?php

declare(strict_types=1);

namespace App\Access;

use App\Contracts\ImageContract;
use App\Processors\BrightnessContrast;
use App\Processors\Crop;
use App\Processors\Custom;
use App\Processors\GreyScale;
use App\Processors\ImageExtensionConverter;
use App\Processors\plugins\ColorBoost as PluginColorBoost;
use App\Processors\plugins\TextCleaner as PluginTextCleaner;
use App\Processors\Scale;
use App\Processors\Tesseract;
use App\Processors\Threshold;
use Illuminate\Pipeline\Pipeline;
use Storage;

class DniBuilder extends Image implements ImageContract
{
    public string $filename;

    public string $fileTxtResult;

    public function __construct($filename)
    {
        parent::__construct();

        $this->filename = $filename;
        $this->fileTxtResult = $this->filename.'.txt';
    }

    public function treatment()
    {
        $this->getDni();
        $this->getPersonalInformation();
        $this->getDates();
        $this->getExtraInformation();
    }

    public function getPersonalInformation()
    {
        app(Pipeline::class)
            ->send($this->filename)
            ->through([
                ImageExtensionConverter::class,
                GreyScale::class,
                new Crop(width: '450', height: '510', x_offset: '343', y_offset: '107'),
                Scale::class,
                new BrightnessContrast(brightness: '15', contrast: '40'),
                new PluginTextCleaner(values: '-g -e stretch -f 35 -o 15 -s 1'),
                Tesseract::class,
            ])
            ->then(function ($content) {
                Storage::disk('images')->append($this->fileTxtResult, $content);
            });
    }

    public function getDni()
    {
        app(Pipeline::class)
            ->send($this->filename)
            ->through([
                ImageExtensionConverter::class,
                GreyScale::class,
                new Crop(width: '1440', height: '50', x_offset: '1115', y_offset: '58'),
                Scale::class,
                new PluginColorBoost(value: '100'),
                new Threshold(percent: '30'),
                Tesseract::class,
            ])
            ->then(function ($content) {
                Storage::disk('images')->append($this->fileTxtResult, $content);
            });
    }

    public function getDates()
    {
        app(Pipeline::class)
            ->send($this->filename)
            ->through([
                ImageExtensionConverter::class,
                GreyScale::class,
                new Crop(width: '1440', height: '310', x_offset: '1110', y_offset: '110'),
                new PluginColorBoost(value: '100'),
                new BrightnessContrast(brightness: '8', contrast: '30'),
                new PluginTextCleaner(values: '-g -e stretch -f 30 -o 10'),
                Tesseract::class,
            ])
            ->then(function ($content) {
                Storage::disk('images')->append($this->fileTxtResult, $content);
            });
    }

    public function getExtraInformation()
    {
        app(Pipeline::class)
            ->send($this->filename)
            ->through([
                ImageExtensionConverter::class,
                GreyScale::class,
                new Crop(width: '1440', height: '920', x_offset: '15', y_offset: '660'),
                new PluginColorBoost(value: '100'),
                new Custom(command: '-brightness-contrast 40x10 -colorspace HSI -alpha off -channel blue -separate +channel'),
                new Threshold(percent: '65'),
                Tesseract::class,
            ])
            ->then(function ($content) {
                Storage::disk('images')->append($this->fileTxtResult, $content);
            });
    }

    public function output()
    {
        return Storage::disk('images')->get($this->fileTxtResult);
    }
}
