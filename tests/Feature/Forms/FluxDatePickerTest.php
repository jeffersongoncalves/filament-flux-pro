<?php

use Illuminate\Support\Carbon;
use Jeffersongoncalves\FilamentFluxPro\Forms\Components\FluxDatePicker;
use Jeffersongoncalves\FilamentFluxPro\Tests\Fixtures\TestForm;
use Livewire\Livewire;

beforeEach(function () {
    TestForm::$fieldsCallback = null;
});

it('defaults to single mode', function () {
    expect(FluxDatePicker::make('published_at')->getFluxMode())->toBe('single');
});

it('switches mode via DSL and rejects garbage', function () {
    expect(FluxDatePicker::make('a')->fluxMode('range')->getFluxMode())->toBe('range');
    expect(FluxDatePicker::make('b')->fluxMode('multiple')->getFluxMode())->toBe('multiple');
    expect(FluxDatePicker::make('c')->fluxMode('whatever')->getFluxMode())->toBe('single');
});

it('exposes Flux date toggles', function () {
    $field = FluxDatePicker::make('published_at')
        ->fluxWithTime()
        ->fluxLocale('pt_BR')
        ->fluxDisplayFormat('d/m/Y')
        ->fluxMin('2026-01-01')
        ->fluxMax('2026-12-31')
        ->fluxPresets(['today', 'last-7-days']);

    expect($field->shouldFluxWithTime())->toBeTrue();
    expect($field->getFluxLocale())->toBe('pt_BR');
    expect($field->getFluxDisplayFormat())->toBe('d/m/Y');
    expect($field->getFluxMin())->toBe('2026-01-01');
    expect($field->getFluxMax())->toBe('2026-12-31');
    expect($field->getFluxPresets())->toBe(['today', 'last-7-days']);
});

it('normalizes custom presets to date-string tuples', function () {
    $field = FluxDatePicker::make('period')->fluxPresets([
        'Q1 2026' => ['2026-01-01', '2026-03-31'],
        'Q2 2026' => [Carbon::parse('2026-04-01'), Carbon::parse('2026-06-30')],
    ]);

    expect($field->getFluxPresets())->toBe([
        'Q1 2026' => ['2026-01-01', '2026-03-31'],
        'Q2 2026' => ['2026-04-01', '2026-06-30'],
    ]);
});

it('renders flux:date-picker markup with state path', function () {
    TestForm::$fieldsCallback = fn () => [
        FluxDatePicker::make('published_at')->fluxMode('single'),
    ];

    $html = Livewire::test(TestForm::class)->html();

    expect($html)->toContain('data.published_at');
});

it('dehydrates single string to Carbon', function () {
    $field = FluxDatePicker::make('published_at');

    $reflection = new ReflectionMethod($field, 'dehydrateFluxDateState');
    $reflection->setAccessible(true);

    $result = $reflection->invoke($field, '2026-05-09');

    expect($result)->toBeInstanceOf(Carbon::class);
    expect($result->toDateString())->toBe('2026-05-09');
});

it('dehydrates range to start/end Carbon array', function () {
    $field = FluxDatePicker::make('period')->fluxMode('range');

    $reflection = new ReflectionMethod($field, 'dehydrateFluxDateState');
    $reflection->setAccessible(true);

    $result = $reflection->invoke($field, ['start' => '2026-01-01', 'end' => '2026-03-31']);

    expect($result)->toBeArray();
    expect($result['start'])->toBeInstanceOf(Carbon::class);
    expect($result['end'])->toBeInstanceOf(Carbon::class);
    expect($result['start']->toDateString())->toBe('2026-01-01');
});

it('dehydrates multiple to list of Carbon', function () {
    $field = FluxDatePicker::make('dates')->fluxMode('multiple');

    $reflection = new ReflectionMethod($field, 'dehydrateFluxDateState');
    $reflection->setAccessible(true);

    $result = $reflection->invoke($field, ['2026-05-09', '2026-05-10']);

    expect($result)->toBeArray()->toHaveCount(2);
    expect($result[0])->toBeInstanceOf(Carbon::class);
});

it('respects required validation', function () {
    TestForm::$fieldsCallback = fn () => [
        FluxDatePicker::make('published_at')->required(),
    ];

    Livewire::test(TestForm::class)
        ->call('save')
        ->assertHasErrors(['data.published_at' => 'required']);
});
