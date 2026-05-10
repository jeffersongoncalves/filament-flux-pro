<?php

use Filament\Panel;
use Jeffersongoncalves\FilamentFlux\FilamentFluxPlugin;
use Jeffersongoncalves\FilamentFluxPro\FilamentFluxProPlugin;

it('exposes a stable plugin id', function () {
    expect(FilamentFluxProPlugin::make()->getId())->toBe('filament-flux-pro');
});

it('defaults every Pro toggle to off', function () {
    $plugin = FilamentFluxProPlugin::make();

    expect($plugin->isCommandPaletteEnabled())->toBeFalse();
    expect($plugin->shouldPreferFluxEditor())->toBeFalse();
    expect($plugin->shouldPreferFluxCharts())->toBeFalse();
    expect($plugin->getCommandPaletteShortcut())->toBe('cmd+k');
});

it('flips Pro toggles via fluent setters', function () {
    $plugin = FilamentFluxProPlugin::make()
        ->enableCommandPalette()
        ->commandPaletteShortcut('ctrl+k')
        ->preferFluxEditor()
        ->preferFluxCharts();

    expect($plugin->isCommandPaletteEnabled())->toBeTrue();
    expect($plugin->getCommandPaletteShortcut())->toBe('ctrl+k');
    expect($plugin->shouldPreferFluxEditor())->toBeTrue();
    expect($plugin->shouldPreferFluxCharts())->toBeTrue();
});

it('throws when the free FilamentFluxPlugin is not registered first', function () {
    $panel = Panel::make()->id('pro-test')->path('pro-test');

    expect(fn () => FilamentFluxProPlugin::make()->register($panel))
        ->toThrow(RuntimeException::class, 'FilamentFluxProPlugin requires FilamentFluxPlugin to be registered first');
});

it('registers cleanly when the free plugin is registered first', function () {
    $panel = Panel::make()
        ->id('pro-test')
        ->path('pro-test')
        ->plugin(FilamentFluxPlugin::make())
        ->plugin(FilamentFluxProPlugin::make());

    expect($panel->hasPlugin(FilamentFluxPlugin::getPluginId()))->toBeTrue();
    expect($panel->hasPlugin(FilamentFluxProPlugin::getPluginId()))->toBeTrue();
});
