<?php

use Jeffersongoncalves\FilamentFluxPro\Forms\Components\FluxSlider;
use Jeffersongoncalves\FilamentFluxPro\Tests\Fixtures\TestForm;
use Livewire\Livewire;

beforeEach(function () {
    TestForm::$fieldsCallback = null;
});

it('defaults to 0..100 with step 1, single mode', function () {
    $field = FluxSlider::make('quality');

    expect($field->getFluxMin())->toBe(0);
    expect($field->getFluxMax())->toBe(100);
    expect($field->getFluxStep())->toBe(1);
    expect($field->isFluxRange())->toBeFalse();
    expect($field->shouldFluxShowValue())->toBeFalse();
});

it('exposes slider DSL', function () {
    $field = FluxSlider::make('quality')
        ->fluxMin(10)
        ->fluxMax(90)
        ->fluxStep(5)
        ->fluxShowValue();

    expect($field->getFluxMin())->toBe(10);
    expect($field->getFluxMax())->toBe(90);
    expect($field->getFluxStep())->toBe(5);
    expect($field->shouldFluxShowValue())->toBeTrue();
});

it('handles range mode with array state', function () {
    $field = FluxSlider::make('budget')
        ->fluxRange()
        ->fluxMin(0)
        ->fluxMax(10000)
        ->fluxStep(100);

    expect($field->isFluxRange())->toBeTrue();

    $reflection = new ReflectionClass($field);
    $property = $reflection->getProperty('dehydrateStateUsing');
    $property->setAccessible(true);
    $callback = $property->getValue($field);

    expect($callback(['1000', '5000']))->toBe([1000, 5000]);
    expect($callback([1000, 5000]))->toBe([1000, 5000]);
});

it('coerces single state to numeric', function () {
    $field = FluxSlider::make('quality');

    $reflection = new ReflectionClass($field);
    $property = $reflection->getProperty('dehydrateStateUsing');
    $property->setAccessible(true);
    $callback = $property->getValue($field);

    expect($callback('42'))->toBe(42);
    expect($callback(null))->toBeNull();
});

it('renders slider bound to state', function () {
    TestForm::$fieldsCallback = fn () => [
        FluxSlider::make('quality'),
    ];

    $html = Livewire::test(TestForm::class)->html();

    expect($html)->toContain('data.quality');
});
