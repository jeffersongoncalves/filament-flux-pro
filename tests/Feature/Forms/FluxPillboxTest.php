<?php

use Jeffersongoncalves\FilamentFluxPro\Forms\Components\FluxPillbox;
use Jeffersongoncalves\FilamentFluxPro\Tests\Fixtures\TestForm;
use Livewire\Livewire;

beforeEach(function () {
    TestForm::$fieldsCallback = null;
});

it('exposes pillbox DSL', function () {
    $field = FluxPillbox::make('tags')
        ->options(['a' => 'A', 'b' => 'B'])
        ->fluxAllowCustom()
        ->fluxMax(5)
        ->fluxClearable();

    expect($field->getFluxOptions())->toBe(['a' => 'A', 'b' => 'B']);
    expect($field->isFluxAllowCustom())->toBeTrue();
    expect($field->getFluxMax())->toBe(5);
    expect($field->isFluxClearable())->toBeTrue();
});

it('caps state to fluxMax on dehydration', function () {
    $field = FluxPillbox::make('tags')->fluxMax(2);

    $reflection = new ReflectionClass($field);
    $property = $reflection->getProperty('dehydrateStateUsing');
    $property->setAccessible(true);
    $callback = $property->getValue($field);

    expect($callback(['a', 'b', 'c', 'd']))->toBe(['a', 'b']);
    expect($callback(['a']))->toBe(['a']);
    expect($callback(null))->toBe([]);
});

it('renders pillbox bound to state', function () {
    TestForm::$fieldsCallback = fn () => [
        FluxPillbox::make('tags')->options(['x' => 'X']),
    ];

    $html = Livewire::test(TestForm::class)->html();

    expect($html)->toContain('data.tags');
});
