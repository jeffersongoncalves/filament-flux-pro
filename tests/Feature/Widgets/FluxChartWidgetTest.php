<?php

use Jeffersongoncalves\FilamentFluxPro\Tests\Fixtures\TestLineChartWidget;
use Jeffersongoncalves\FilamentFluxPro\Widgets\FluxAreaChartWidget;
use Jeffersongoncalves\FilamentFluxPro\Widgets\FluxBarChartWidget;
use Jeffersongoncalves\FilamentFluxPro\Widgets\FluxChartWidget;
use Jeffersongoncalves\FilamentFluxPro\Widgets\FluxLineChartWidget;

it('exposes type per subclass', function () {
    $reflection = new ReflectionMethod(FluxLineChartWidget::class, 'getType');
    $reflection->setAccessible(true);

    expect($reflection->invoke(new TestLineChartWidget))->toBe('line');
});

it('every chart subclass extends FluxChartWidget', function () {
    expect(is_subclass_of(FluxLineChartWidget::class, FluxChartWidget::class))->toBeTrue();
    expect(is_subclass_of(FluxAreaChartWidget::class, FluxChartWidget::class))->toBeTrue();
    expect(is_subclass_of(FluxBarChartWidget::class, FluxChartWidget::class))->toBeTrue();
});

it('builds view data from fixture widget', function () {
    $widget = new TestLineChartWidget;

    $reflection = new ReflectionMethod($widget, 'getViewData');
    $reflection->setAccessible(true);

    $data = $reflection->invoke($widget);

    expect($data)
        ->toHaveKeys(['type', 'data', 'options', 'height', 'heading', 'description']);
    expect($data['type'])->toBe('line');
    expect($data['height'])->toBe(300);
    expect($data['heading'])->toBe('Revenue');
    expect($data['description'])->toBe('Last 12 months');
    expect($data['options'])
        ->toHaveKeys(['colors', 'showLegend', 'showGrid', 'showAxis']);
    expect($data['data'])->toHaveCount(3);
});
