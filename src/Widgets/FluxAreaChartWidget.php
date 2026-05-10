<?php

namespace Jeffersongoncalves\FilamentFluxPro\Widgets;

abstract class FluxAreaChartWidget extends FluxChartWidget
{
    protected function getType(): string
    {
        return 'area';
    }
}
