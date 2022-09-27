<?php

namespace Erkurn\FilamentAddressPicker;

use Filament\PluginServiceProvider;
use Spatie\LaravelPackageTools\Package;

class FilamentAddressPickerServiceProvider extends PluginServiceProvider
{
    protected array $beforeCoreScripts = [
        'filament-address-picker-scripts' => __DIR__.'/../resources/dist/js/filament-address-picker.js',
    ];

    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-address-picker')
            ->hasConfigFile()
            ->hasViews();
    }
}
