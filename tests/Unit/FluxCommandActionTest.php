<?php

use Jeffersongoncalves\FilamentFluxPro\Actions\FluxCommandAction;

it('returns empty commands by default', function () {
    expect(FluxCommandAction::make('actions')->getFluxCommands())->toBe([]);
});

it('accepts a static command map', function () {
    $action = FluxCommandAction::make('actions')->fluxCommands([
        'edit' => ['label' => 'Edit', 'handler' => fn () => 'edit'],
        'archive' => ['label' => 'Archive', 'handler' => fn () => 'archive'],
    ]);

    $commands = $action->getFluxCommands();

    expect($commands)->toHaveKeys(['edit', 'archive']);
    expect($commands['edit']['label'])->toBe('Edit');
});

it('resolves commands closure with record context', function () {
    $action = FluxCommandAction::make('actions')->fluxCommands(
        fn ($record) => [
            'do' => ['label' => "Do {$record['id']}", 'handler' => fn () => null],
        ],
    );

    $commands = $action->getFluxCommands(['id' => 7]);

    expect($commands['do']['label'])->toBe('Do 7');
});
