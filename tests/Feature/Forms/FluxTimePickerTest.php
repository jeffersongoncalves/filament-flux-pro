<?php

use Jeffersongoncalves\FilamentFluxPro\Forms\Components\FluxTimePicker;
use Jeffersongoncalves\FilamentFluxPro\Tests\Fixtures\TestForm;
use Livewire\Livewire;

beforeEach(function () {
    TestForm::$fieldsCallback = null;
});

it('defaults step to 60 seconds', function () {
    expect(FluxTimePicker::make('start')->getFluxStep())->toBe(60);
});

it('exposes step/min/max DSL', function () {
    $field = FluxTimePicker::make('slot')
        ->fluxStep(900)
        ->fluxMin('08:00')
        ->fluxMax('18:00');

    expect($field->getFluxStep())->toBe(900);
    expect($field->getFluxMin())->toBe('08:00:00');
    expect($field->getFluxMax())->toBe('18:00:00');
});

it('renders type=time input bound to state', function () {
    TestForm::$fieldsCallback = fn () => [
        FluxTimePicker::make('slot'),
    ];

    $html = Livewire::test(TestForm::class)->html();

    expect($html)->toContain('data.slot');
});
