<?php

namespace Imeysam\Picsize\Providers;

use Illuminate\Support\ServiceProvider;
use Imeysam\Picsize\Picsize;
use Imeysam\Picsize\Contracts\PicsizeInterface;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;

class PicsizeServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/picsize.php', 'picsize');

        $this->app->scoped(PicsizeInterface::class, function ($app) {
            return new Picsize(ImageManager::usingDriver(GdDriver::class));
        });

        $this->app->alias(PicsizeInterface::class, 'laravel-picsize');
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../../config/picsize.php' => config_path('picsize.php'),
        ], 'config');
    }
}
