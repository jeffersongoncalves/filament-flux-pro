<?php

use Jeffersongoncalves\FilamentFluxPro\Forms\Components\FluxEditor;
use Jeffersongoncalves\FilamentFluxPro\Tests\Fixtures\TestForm;
use Livewire\Livewire;

beforeEach(function () {
    TestForm::$fieldsCallback = null;
});

it('exposes editor DSL', function () {
    $field = FluxEditor::make('content')
        ->fluxToolbar(['bold', 'italic', '|', 'undo'])
        ->fluxMenu()
        ->fluxMinHeight('200px')
        ->fluxMaxHeight('600px')
        ->fluxSanitize();

    expect($field->getFluxToolbar())->toBe(['bold', 'italic', '|', 'undo']);
    expect($field->shouldFluxMenu())->toBeTrue();
    expect($field->getFluxMinHeight())->toBe('200px');
    expect($field->getFluxMaxHeight())->toBe('600px');
    expect($field->shouldFluxSanitize())->toBeTrue();
});

it('configures image upload via fluxImageUpload', function () {
    $field = FluxEditor::make('content')
        ->fluxImageUpload(
            disk: 's3',
            directory: 'editor/images',
            visibility: 'private',
            maxSize: 5120,
            accept: ['image/jpeg', 'image/png'],
        );

    expect($field->getFluxImageDisk())->toBe('s3');
    expect($field->getFluxImageDirectory())->toBe('editor/images');
    expect($field->getFluxImageVisibility())->toBe('private');
    expect($field->getFluxImageMaxSize())->toBe(5120);
    expect($field->getFluxImageAccept())->toBe(['image/jpeg', 'image/png']);
    expect($field->isFluxImageUploadEnabled())->toBeTrue();
});

it('renders editor bound to state', function () {
    TestForm::$fieldsCallback = fn () => [
        FluxEditor::make('content'),
    ];

    $html = Livewire::test(TestForm::class)->html();

    expect($html)->toContain('data.content');
});

it('sanitizes HTML on dehydration when fluxSanitize is true', function () {
    $field = FluxEditor::make('content');

    $reflection = new ReflectionClass($field);
    $property = $reflection->getProperty('dehydrateStateUsing');
    $property->setAccessible(true);
    $callback = $property->getValue($field);

    $dirty = '<p>Hello</p><script>alert(1)</script>';
    $clean = $callback($dirty);

    expect($clean)->not->toContain('<script>');
    expect($clean)->toContain('<p>Hello</p>');
});
