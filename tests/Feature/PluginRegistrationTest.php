<?php

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TagsInput;
use Filament\Panel;
use Jeffersongoncalves\FilamentFlux\FilamentFluxPlugin;
use Jeffersongoncalves\FilamentFluxPro\FilamentFluxProPlugin;
use Jeffersongoncalves\FilamentFluxPro\Forms\Components\FluxDatePicker;
use Jeffersongoncalves\FilamentFluxPro\Forms\Components\FluxEditor;
use Jeffersongoncalves\FilamentFluxPro\Forms\Components\FluxFileUpload;
use Jeffersongoncalves\FilamentFluxPro\Forms\Components\FluxPillbox;

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

it('disables every Pro binding by default', function () {
    expect(FilamentFluxProPlugin::make()->getActiveBindings())->toBe([]);
});

it('useEverywhere(true) activates every Pro binding', function () {
    $active = FilamentFluxProPlugin::make()->useEverywhere()->getActiveBindings();

    expect($active)->toBe(array_keys(FilamentFluxProPlugin::FIELD_BINDINGS));
});

it('useEverywhere accepts partial overrides keyed by slug', function () {
    $active = FilamentFluxProPlugin::make()
        ->useEverywhere(['datePicker' => true, 'fileUpload' => false])
        ->getActiveBindings();

    expect($active)->toContain('datePicker');
    expect($active)->not->toContain('fileUpload');
    expect($active)->toContain('richEditor');
});

it('useEverywhere(false) clears every binding', function () {
    expect(
        FilamentFluxProPlugin::make()
            ->useEverywhere()
            ->useEverywhere(false)
            ->getActiveBindings()
    )->toBe([]);
});

it('rebinds Filament classes to Flux Pro classes when registered', function () {
    Panel::make()
        ->id('pro-bind')
        ->path('pro-bind')
        ->plugin(FilamentFluxPlugin::make())
        ->plugin(FilamentFluxProPlugin::make()->useEverywhere());

    expect(app(DatePicker::class, ['name' => 'a']))->toBeInstanceOf(FluxDatePicker::class);
    expect(app(RichEditor::class, ['name' => 'b']))->toBeInstanceOf(FluxEditor::class);
    expect(app(FileUpload::class, ['name' => 'c']))->toBeInstanceOf(FluxFileUpload::class);
    expect(app(TagsInput::class, ['name' => 'd']))->toBeInstanceOf(FluxPillbox::class);
});
