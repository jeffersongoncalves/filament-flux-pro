<?php

use Jeffersongoncalves\FilamentFluxPro\Components\FluxContextMenu;

it('builds an empty flux:context-menu', function () {
    expect((string) FluxContextMenu::make())
        ->toContain('<flux:context-menu>')
        ->toContain('</flux:context-menu>');
});

it('renders items with optional icon and danger variant', function () {
    $html = (string) FluxContextMenu::make()
        ->item('Edit', 'editRecord', icon: 'pencil')
        ->item('Delete', 'deleteRecord', icon: 'trash', danger: true);

    expect($html)
        ->toContain('icon="pencil"')
        ->toContain('wire:click="editRecord"')
        ->toContain('variant="danger"')
        ->toContain('wire:click="deleteRecord"')
        ->toContain('Edit')
        ->toContain('Delete');
});

it('renders a separator between items', function () {
    $html = (string) FluxContextMenu::make()
        ->item('A', 'a')
        ->separator()
        ->item('B', 'b');

    expect($html)->toContain('<flux:menu.separator />');
});

it('escapes label text', function () {
    $html = (string) FluxContextMenu::make()->item('<script>x</script>', 'a');

    expect($html)
        ->not->toContain('<script>')
        ->toContain('&lt;script&gt;');
});
