<?php

declare(strict_types=1);

namespace NicolasKion\Esi;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class EsiServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('esi')
            ->hasConfigFile();

        $this->publishes([
            __DIR__.'/Config/esi.php' => config_path('esi.php'),
        ], 'esi-config');
    }
}
