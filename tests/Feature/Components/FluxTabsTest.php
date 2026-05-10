<?php

use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Jeffersongoncalves\FilamentFluxPro\Components\FluxTabs;

it('extends Filament Tabs and forwards label', function () {
    $component = FluxTabs::make('Settings');

    expect($component)->toBeInstanceOf(Tabs::class);
    expect($component->getLabel())->toBe('Settings');
});

it('uses the custom flux-pro view', function () {
    $component = FluxTabs::make('x');

    $reflection = new ReflectionClass($component);
    $property = $reflection->getProperty('view');
    $property->setAccessible(true);

    expect($property->getValue($component))->toBe('filament-flux-pro::components.tabs');
});

it('exposes fluxVariant DSL', function () {
    $component = FluxTabs::make('x')->fluxVariant('pills');

    expect($component->getFluxVariant())->toBe('pills');
});

it('accepts tab children via tabs() helper', function () {
    $component = FluxTabs::make('x')->tabs([
        Tab::make('one'),
        Tab::make('two'),
        Tab::make('three'),
    ]);

    expect($component->getDefaultChildComponents())->toHaveCount(3);
});
