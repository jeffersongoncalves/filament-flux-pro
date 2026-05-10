<?php

use Jeffersongoncalves\FilamentFluxPro\Forms\Components\FluxDateTimePicker;
use Jeffersongoncalves\FilamentFluxPro\Tests\Fixtures\TestForm;
use Livewire\Livewire;

beforeEach(function () {
    TestForm::$fieldsCallback = null;
});

it('forces with-time on by default', function () {
    expect(FluxDateTimePicker::make('starts_at')->shouldFluxWithTime())->toBeTrue();
});

it('renders with state path', function () {
    TestForm::$fieldsCallback = fn () => [
        FluxDateTimePicker::make('starts_at'),
    ];

    $html = Livewire::test(TestForm::class)->html();

    expect($html)->toContain('data.starts_at');
});
