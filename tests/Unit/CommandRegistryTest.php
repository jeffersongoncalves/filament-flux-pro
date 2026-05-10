<?php

use Jeffersongoncalves\FilamentFluxPro\Support\CommandRegistry;

it('adds, has, and removes commands', function () {
    $registry = (new CommandRegistry)
        ->add('a', 'Alpha', fn () => 1, icon: 'star')
        ->add('b', 'Beta', fn () => 2);

    expect($registry->has('a'))->toBeTrue();
    expect($registry->has('z'))->toBeFalse();

    $registry->remove('a');

    expect($registry->has('a'))->toBeFalse();
    expect($registry->all())->toHaveKey('b');
});

it('searches commands case-insensitively by label', function () {
    $registry = (new CommandRegistry)
        ->add('inv', 'Nova fatura', fn () => 1)
        ->add('cust', 'Ir para clientes', fn () => 2)
        ->add('rep', 'Ver relatório', fn () => 3);

    expect($registry->search('FATURA'))->toHaveKey('inv');
    expect($registry->search('cliente'))->toHaveKey('cust');
    expect($registry->search(''))->toHaveCount(3);
    expect($registry->search('xxx'))->toBe([]);
});

it('executes a command by key and returns its result', function () {
    $registry = (new CommandRegistry)
        ->add('hello', 'Say hi', fn (string $name) => "hi {$name}");

    expect($registry->execute('hello', 'jeff'))->toBe('hi jeff');
    expect($registry->execute('missing'))->toBeNull();
});
