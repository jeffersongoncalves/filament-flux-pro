<?php

namespace Jeffersongoncalves\FilamentFluxPro;

use Jeffersongoncalves\FilamentFluxPro\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentFluxProServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-flux-pro';

    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasConfigFile()
            ->hasViews(static::$name)
            ->hasCommands([
                InstallCommand::class,
            ]);
    }
}
