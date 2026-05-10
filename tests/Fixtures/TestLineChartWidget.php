<?php

namespace Jeffersongoncalves\FilamentFluxPro\Tests\Fixtures;

use Jeffersongoncalves\FilamentFluxPro\Widgets\FluxLineChartWidget;

class TestLineChartWidget extends FluxLineChartWidget
{
    protected static ?string $heading = 'Revenue';

    protected ?string $description = 'Last 12 months';

    protected int $height = 300;

    protected function getData(): array
    {
        return [
            ['date' => '2026-01', 'revenue' => 100],
            ['date' => '2026-02', 'revenue' => 200],
            ['date' => '2026-03', 'revenue' => 150],
        ];
    }
}
