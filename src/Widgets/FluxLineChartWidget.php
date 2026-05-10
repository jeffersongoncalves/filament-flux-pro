<?php

namespace Jeffersongoncalves\FilamentFluxPro\Widgets;

abstract class FluxLineChartWidget extends FluxChartWidget
{
    protected function getType(): string
    {
        return 'line';
    }
}
