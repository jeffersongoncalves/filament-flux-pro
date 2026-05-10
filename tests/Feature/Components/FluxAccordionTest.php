<?php

use Jeffersongoncalves\FilamentFluxPro\Components\FluxAccordion;

it('defaults to collapsed', function () {
    expect(FluxAccordion::make('advanced')->isFluxExpanded())->toBeFalse();
});

it('exposes accordion DSL', function () {
    $component = FluxAccordion::make('advanced')
        ->fluxHeading('Advanced')
        ->fluxIcon('cog-6-tooth')
        ->fluxExpanded();

    expect($component->getHeading())->toBe('Advanced');
    expect($component->getIcon())->toBe('cog-6-tooth');
    expect($component->isFluxExpanded())->toBeTrue();
});

it('uses the custom flux-pro view', function () {
    $component = FluxAccordion::make('advanced');

    $reflection = new ReflectionClass($component);
    $property = $reflection->getProperty('view');
    $property->setAccessible(true);

    expect($property->getValue($component))->toBe('filament-flux-pro::components.accordion');
});
