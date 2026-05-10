<?php

use Jeffersongoncalves\FilamentFluxPro\Forms\Components\FluxFileUpload;
use Jeffersongoncalves\FilamentFluxPro\Tests\Fixtures\TestForm;
use Livewire\Livewire;

beforeEach(function () {
    TestForm::$fieldsCallback = null;
});

it('exposes file-upload DSL', function () {
    $field = FluxFileUpload::make('attachments')
        ->fluxAccept(['image/*', 'application/pdf'])
        ->fluxMultiple()
        ->fluxMaxSize(10240)
        ->fluxDisk('s3')
        ->fluxDirectory('uploads/users')
        ->fluxVisibility('private');

    expect($field->getFluxAccept())->toBe(['image/*', 'application/pdf']);
    expect($field->shouldFluxMultiple())->toBeTrue();
    expect($field->getFluxMaxSize())->toBe(10240);
    expect($field->getFluxDisk())->toBe('s3');
    expect($field->getFluxDirectory())->toBe('uploads/users');
    expect($field->getFluxVisibility())->toBe('private');
});

it('defaults multiple to false and visibility to public', function () {
    $field = FluxFileUpload::make('avatar');

    expect($field->shouldFluxMultiple())->toBeFalse();
    expect($field->getFluxVisibility())->toBe('public');
    expect($field->getFluxAccept())->toBeNull();
    expect($field->getFluxMaxSize())->toBeNull();
});

it('renders file-upload bound to state', function () {
    TestForm::$fieldsCallback = fn () => [
        FluxFileUpload::make('attachments')->fluxMultiple(),
    ];

    $html = Livewire::test(TestForm::class)->html();

    expect($html)->toContain('data.attachments');
});
