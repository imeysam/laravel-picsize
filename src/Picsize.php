<?php

namespace Imeysam\Picsize;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Imeysam\Picsize\Contracts\PicsizeInterface;
class Picsize implements PicsizeInterface
{
    protected ImageManager $imageManager;
    protected string $disk;
    protected string $inputPath;
    protected string $outputPath;
    protected string $fallbackImage;

    public function __construct(ImageManager $imageManager)
    {
        $this->imageManager = $imageManager;

        $this->disk = config('picsize.disk', 'public');
        $this->inputPath = trim(config('picsize.input_path', 'uploads'), '/');
        $this->outputPath = trim(config('picsize.output_path', 'images'), '/');
        $this->fallbackImage = config('picsize.fallback_image', 'images/default.jpg');
    }

    public function resize(?string $sourcePath, int $width, int $height): string
    {
        if (empty($sourcePath)) {
            $sourcePath = $this->fallbackImage;
        }

        $sourcePath = ltrim($sourcePath, '/');
        $inputFullPath = "{$this->inputPath}/{$sourcePath}";
        $disk = Storage::disk($this->disk);

        if (!$disk->exists($inputFullPath)) {
            $sourcePath = $this->fallbackImage;
            $inputFullPath = $this->fallbackImage;
        }

        $dirname = pathinfo($sourcePath, PATHINFO_DIRNAME);
        $filename = "";
        if (!empty($dirname) && $dirname !== '.') {
            $filename .= ($dirname . DIRECTORY_SEPARATOR);
        }
        $filename .= pathinfo($sourcePath, PATHINFO_FILENAME);
        $extension = pathinfo($sourcePath, PATHINFO_EXTENSION);

        $outputName = "{$filename}_{$width}x{$height}.{$extension}";
        $outputFullPath = "{$this->outputPath}/{$outputName}";

        if ($disk->exists($outputFullPath)) {
            return $disk->url($outputFullPath);
        }

        $sourceStream = $disk->get($inputFullPath);
        $image = $this->imageManager->decode($sourceStream);

        $image->coverDown(width: $width, height: $height);
        $encoded = $image->encodeUsingFileExtension($extension);

        $disk->put($outputFullPath, $encoded->toString());
        return $disk->url($outputFullPath);
    }
}
