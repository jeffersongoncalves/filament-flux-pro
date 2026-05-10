<?php

use Jeffersongoncalves\FilamentFluxPro\Forms\Components\FluxColorPicker;
use Jeffersongoncalves\FilamentFluxPro\Tests\Fixtures\TestForm;
use Livewire\Livewire;

beforeEach(function () {
    TestForm::$fieldsCallback = null;
});

it('defaults format to hex', function () {
    expect(FluxColorPicker::make('brand_color')->getFluxFormat())->toBe('hex');
});

it('switches format via DSL and rejects garbage', function () {
    expect(FluxColorPicker::make('a')->fluxFormat('rgb')->getFluxFormat())->toBe('rgb');
    expect(FluxColorPicker::make('b')->fluxFormat('hsl')->getFluxFormat())->toBe('hsl');
    expect(FluxColorPicker::make('c')->fluxFormat('cmyk')->getFluxFormat())->toBe('hex');
});

it('exposes swatches/alpha/inline DSL', function () {
    $field = FluxColorPicker::make('brand_color')
        ->fluxSwatches(['#ef4444', '#22c55e'])
        ->fluxAlpha()
        ->fluxInline();

    expect($field->getFluxSwatches())->toBe(['#ef4444', '#22c55e']);
    expect($field->shouldFluxAlpha())->toBeTrue();
    expect($field->shouldFluxInline())->toBeTrue();
});

it('renders flux:color-picker bound to state', function () {
    TestForm::$fieldsCallback = fn () => [
        FluxColorPicker::make('brand_color'),
    ];

    $html = Livewire::test(TestForm::class)->html();

    expect($html)->toContain('data.brand_color');
});
