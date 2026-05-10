<?php

use Jeffersongoncalves\FilamentFluxPro\Forms\Components\FluxComposer;
use Jeffersongoncalves\FilamentFluxPro\Tests\Fixtures\TestForm;
use Livewire\Livewire;

beforeEach(function () {
    TestForm::$fieldsCallback = null;
});

it('exposes composer DSL', function () {
    $field = FluxComposer::make('message')
        ->fluxAllowAttachments()
        ->fluxAllowMentions(fn (string $search) => [1 => "User: {$search}"])
        ->fluxPlaceholder('Type…')
        ->fluxSubmitOnEnter()
        ->fluxVariant('input');

    expect($field->shouldFluxAllowAttachments())->toBeTrue();
    expect($field->hasFluxMentionsResolver())->toBeTrue();
    expect($field->getFluxPlaceholder())->toBe('Type…');
    expect($field->shouldFluxSubmitOnEnter())->toBeTrue();
    expect($field->getFluxVariant())->toBe('input');
});

it('resolves mentions through the closure', function () {
    $field = FluxComposer::make('message')
        ->fluxAllowMentions(fn (string $search) => [1 => "Match: {$search}"]);

    expect($field->getFluxMentions('jeff'))->toBe([1 => 'Match: jeff']);
});

it('returns empty mentions array when no resolver is set', function () {
    expect(FluxComposer::make('message')->getFluxMentions('foo'))->toBe([]);
});

it('passes string state through dehydration unchanged', function () {
    $field = FluxComposer::make('message');

    $reflection = new ReflectionClass($field);
    $property = $reflection->getProperty('dehydrateStateUsing');
    $property->setAccessible(true);
    $callback = $property->getValue($field);

    expect($callback('hello'))->toBe('hello');
    expect($callback(null))->toBeNull();
});

it('normalizes array state with text + attachments + mentions', function () {
    $field = FluxComposer::make('message');

    $reflection = new ReflectionClass($field);
    $property = $reflection->getProperty('dehydrateStateUsing');
    $property->setAccessible(true);
    $callback = $property->getValue($field);

    $result = $callback([
        'text' => 'hi',
        'attachments' => ['x' => '/tmp/a.png'],
        'mentions' => ['y' => 42],
    ]);

    expect($result)->toBe([
        'text' => 'hi',
        'attachments' => ['/tmp/a.png'],
        'mentions' => [42],
    ]);
});

it('returns null on empty array state', function () {
    $field = FluxComposer::make('message');

    $reflection = new ReflectionClass($field);
    $property = $reflection->getProperty('dehydrateStateUsing');
    $property->setAccessible(true);
    $callback = $property->getValue($field);

    expect($callback(['text' => '', 'attachments' => [], 'mentions' => []]))->toBeNull();
});

it('renders composer bound to state', function () {
    TestForm::$fieldsCallback = fn () => [
        FluxComposer::make('message'),
    ];

    $html = Livewire::test(TestForm::class)->html();

    expect($html)->toContain('data.message');
});
