<?php

use Jeffersongoncalves\FilamentFluxPro\Pages\Concerns\HasCommandPalette;

class FakePalettePage
{
    use HasCommandPalette;

    public int $created = 0;

    protected function getCommandPaletteCommands(): array
    {
        return [
            'create' => [
                'label' => 'Nova fatura',
                'icon' => 'document-plus',
                'handler' => function ($page) {
                    $page->created++;
                },
            ],
            'go' => [
                'label' => 'Ir para clientes',
                'handler' => fn () => null,
            ],
        ];
    }

    public function getFilteredCommandsForTesting(): array
    {
        return $this->getFilteredCommands();
    }
}

it('opens, closes and toggles the palette', function () {
    $page = new FakePalettePage;

    expect($page->isCommandPaletteOpen)->toBeFalse();

    $page->openCommandPalette();
    expect($page->isCommandPaletteOpen)->toBeTrue();

    $page->commandSearch = 'foo';
    $page->closeCommandPalette();

    expect($page->isCommandPaletteOpen)->toBeFalse();
    expect($page->commandSearch)->toBe('');

    $page->toggleCommandPalette();
    expect($page->isCommandPaletteOpen)->toBeTrue();
});

it('executes a command and closes the palette', function () {
    $page = new FakePalettePage;
    $page->openCommandPalette();

    $page->executeCommand('create');

    expect($page->created)->toBe(1);
    expect($page->isCommandPaletteOpen)->toBeFalse();
});

it('returns null and does not throw on unknown commands', function () {
    $page = new FakePalettePage;

    expect($page->executeCommand('unknown'))->toBeNull();
});

it('filters commands by case-insensitive search', function () {
    $page = new FakePalettePage;

    $page->commandSearch = 'fatura';
    expect($page->getFilteredCommandsForTesting())->toHaveKey('create');
    expect($page->getFilteredCommandsForTesting())->not->toHaveKey('go');

    $page->commandSearch = '';
    expect($page->getFilteredCommandsForTesting())->toHaveCount(2);
});
