<?php

namespace Superscript\FilamentCodemirror;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentCodemirrorServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-codemirror')
            ->hasConfigFile()
            ->hasViews();
    }

    public function packageBooted(): void
    {
        // Register any additional package booting logic here
    }
}
