<?php

namespace Jeffersongoncalves\FilamentFluxPro\Widgets;

abstract class FluxBarChartWidget extends FluxChartWidget
{
    protected function getType(): string
    {
        return 'bar';
    }
}
