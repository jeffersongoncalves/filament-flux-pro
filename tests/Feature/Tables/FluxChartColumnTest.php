<?php

use Jeffersongoncalves\FilamentFluxPro\Tables\Columns\FluxChartColumn;

it('defaults to line type, hidden axis/legend, height 40, min width 80', function () {
    $column = FluxChartColumn::make('trend');

    expect($column->getFluxType())->toBe('line');
    expect($column->shouldFluxShowAxis())->toBeFalse();
    expect($column->shouldFluxShowLegend())->toBeFalse();
    expect($column->getFluxHeight())->toBe(40);
    expect($column->getFluxMinWidth())->toBe(80);
});

it('exposes column DSL', function () {
    $column = FluxChartColumn::make('trend')
        ->fluxType('area')
        ->fluxColor('lime')
        ->fluxHeight(60)
        ->fluxMinWidth(120)
        ->fluxShowAxis()
        ->fluxShowLegend();

    expect($column->getFluxType())->toBe('area');
    expect($column->getFluxColor())->toBe('lime');
    expect($column->getFluxHeight())->toBe(60);
    expect($column->getFluxMinWidth())->toBe(120);
    expect($column->shouldFluxShowAxis())->toBeTrue();
    expect($column->shouldFluxShowLegend())->toBeTrue();
});

it('resolves data via fluxData closure with record', function () {
    $column = FluxChartColumn::make('trend')
        ->fluxData(fn ($record) => $record['series']);

    $record = ['series' => [
        ['x' => 1, 'y' => 10],
        ['x' => 2, 'y' => 20],
    ]];

    expect($column->getFluxData($record))->toBe($record['series']);
});

it('returns empty array when no data set', function () {
    $column = FluxChartColumn::make('trend');

    expect($column->getFluxData())->toBe([]);
});

it('accepts color as static string', function () {
    $column = FluxChartColumn::make('trend')->fluxColor('lime');

    expect($column->getFluxColor())->toBe('lime');
});
