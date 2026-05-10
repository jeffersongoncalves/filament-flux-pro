<?php

use Jeffersongoncalves\FilamentFluxPro\Components\FluxPopover;

it('builds a flux:popover wrapper around trigger and content', function () {
    $html = (string) FluxPopover::trigger(
        '<flux:button>open</flux:button>',
        '<flux:heading>Title</flux:heading>',
        'top',
    );

    expect($html)
        ->toContain('<flux:popover position="top">')
        ->toContain('<flux:button>open</flux:button>')
        ->toContain('<flux:popover.content>')
        ->toContain('<flux:heading>Title</flux:heading>');
});

it('escapes the position attribute', function () {
    $html = (string) FluxPopover::trigger('a', 'b', '"><script>alert(1)</script>');

    expect($html)
        ->not->toContain('<script>')
        ->toContain('&quot;');
});
