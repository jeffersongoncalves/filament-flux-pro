<?php

use Jeffersongoncalves\FilamentFluxPro\Support\KanbanColumnDefinition;

it('builds a column with id and title', function () {
    $column = KanbanColumnDefinition::make('todo', 'A fazer');

    expect($column->id)->toBe('todo');
    expect($column->title)->toBe('A fazer');
    expect($column->color)->toBeNull();
    expect($column->titleField)->toBe('title');
    expect($column->descriptionField)->toBe('description');
});

it('chains color/titleField/descriptionField/meta fluently', function () {
    $closure = fn ($r) => 'meta:'.$r->id;

    $column = KanbanColumnDefinition::make('done', 'Concluído')
        ->color('lime')
        ->titleField('name')
        ->descriptionField('summary')
        ->meta($closure);

    expect($column->color)->toBe('lime');
    expect($column->titleField)->toBe('name');
    expect($column->descriptionField)->toBe('summary');
    expect($column->renderMeta)->toBe($closure);
});

it('invokes meta closure with record', function () {
    $column = KanbanColumnDefinition::make('done', 'Done')
        ->meta(fn ($record) => 'meta:'.$record->id);

    $record = (object) ['id' => 7];

    expect(($column->renderMeta)($record))->toBe('meta:7');
});
