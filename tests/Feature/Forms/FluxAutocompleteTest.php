<?php

use Jeffersongoncalves\FilamentFluxPro\Forms\Components\FluxAutocomplete;
use Jeffersongoncalves\FilamentFluxPro\Tests\Fixtures\TestForm;
use Livewire\Livewire;

beforeEach(function () {
    TestForm::$fieldsCallback = null;
});

it('defaults to searchable with min chars 0 and debounce 300', function () {
    $field = FluxAutocomplete::make('user_id');

    expect($field->shouldFluxSearchable())->toBeTrue();
    expect($field->getFluxMinChars())->toBe(0);
    expect($field->getFluxDebounce())->toBe(300);
    expect($field->hasFluxOptionsResolver())->toBeFalse();
});

it('exposes async resolver and consumes search string', function () {
    $field = FluxAutocomplete::make('user_id')
        ->fluxMinChars(2)
        ->fluxDebounce(500)
        ->fluxOptionsResolver(fn (string $search) => [
            1 => "Match: {$search}",
            2 => 'Static',
        ]);

    expect($field->hasFluxOptionsResolver())->toBeTrue();
    expect($field->getFluxMinChars())->toBe(2);
    expect($field->getFluxDebounce())->toBe(500);
    expect($field->getFluxOptions('jeff'))->toBe([
        1 => 'Match: jeff',
        2 => 'Static',
    ]);
});

it('falls back to static options when no search string is given', function () {
    $field = FluxAutocomplete::make('user_id')
        ->options([1 => 'Alice', 2 => 'Bob'])
        ->fluxOptionsResolver(fn (string $search) => [99 => 'Async']);

    expect($field->getFluxOptions(''))->toBe([1 => 'Alice', 2 => 'Bob']);
    expect($field->getFluxOptions('a'))->toBe([99 => 'Async']);
});

it('renders autocomplete bound to state', function () {
    TestForm::$fieldsCallback = fn () => [
        FluxAutocomplete::make('user_id')->options([1 => 'A']),
    ];

    $html = Livewire::test(TestForm::class)->html();

    expect($html)->toContain('data.user_id');
});
