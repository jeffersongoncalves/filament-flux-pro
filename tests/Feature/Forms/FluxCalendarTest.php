<?php

use Illuminate\Support\Carbon;
use Jeffersongoncalves\FilamentFluxPro\Forms\Components\FluxCalendar;
use Jeffersongoncalves\FilamentFluxPro\Tests\Fixtures\TestForm;
use Livewire\Livewire;

beforeEach(function () {
    TestForm::$fieldsCallback = null;
});

it('defaults to single mode', function () {
    expect(FluxCalendar::make('availability')->getFluxMode())->toBe('single');
});

it('exposes calendar DSL', function () {
    $field = FluxCalendar::make('availability')
        ->fluxMode('multiple')
        ->fluxLocale('pt_BR')
        ->fluxMonths(2)
        ->fluxAvailableDates([Carbon::parse('2026-05-09'), '2026-05-10']);

    expect($field->getFluxMode())->toBe('multiple');
    expect($field->getFluxLocale())->toBe('pt_BR');
    expect($field->getFluxMonths())->toBe(2);
    expect($field->getFluxAvailableDates())->toBe(['2026-05-09', '2026-05-10']);
});

it('renders inline calendar bound to state', function () {
    TestForm::$fieldsCallback = fn () => [
        FluxCalendar::make('availability'),
    ];

    $html = Livewire::test(TestForm::class)->html();

    expect($html)->toContain('data.availability');
});
