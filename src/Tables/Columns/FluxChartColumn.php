<?php

namespace Jeffersongoncalves\FilamentFluxPro\Tables\Columns;

use Closure;
use Filament\Tables\Columns\Column;
use Jeffersongoncalves\FilamentFluxPro\Concerns\HasFluxChartData;

class FluxChartColumn extends Column
{
    use HasFluxChartData;

    protected string $view = 'filament-flux-pro::components.chart-column';

    protected string|Closure $fluxType = 'line';

    protected string|Closure|null $fluxColor = null;

    protected int|Closure $fluxHeight = 40;

    protected bool|Closure $fluxShowAxis = false;

    protected bool|Closure $fluxShowLegend = false;

    protected int|Closure $fluxMinWidth = 80;

    public function fluxType(string|Closure $type): static
    {
        $this->fluxType = $type;

        return $this;
    }

    public function fluxColor(string|Closure|null $color): static
    {
        $this->fluxColor = $color;

        return $this;
    }

    public function fluxHeight(int|Closure $px): static
    {
        $this->fluxHeight = $px;

        return $this;
    }

    public function fluxShowAxis(bool|Closure $show = true): static
    {
        $this->fluxShowAxis = $show;

        return $this;
    }

    public function fluxShowLegend(bool|Closure $show = true): static
    {
        $this->fluxShowLegend = $show;

        return $this;
    }

    public function fluxMinWidth(int|Closure $px): static
    {
        $this->fluxMinWidth = $px;

        return $this;
    }

    public function getFluxType(): string
    {
        return (string) $this->evaluate($this->fluxType);
    }

    public function getFluxColor(): ?string
    {
        return $this->evaluate($this->fluxColor);
    }

    public function getFluxHeight(): int
    {
        return (int) $this->evaluate($this->fluxHeight);
    }

    public function shouldFluxShowAxis(): bool
    {
        return (bool) $this->evaluate($this->fluxShowAxis);
    }

    public function shouldFluxShowLegend(): bool
    {
        return (bool) $this->evaluate($this->fluxShowLegend);
    }

    public function getFluxMinWidth(): int
    {
        return (int) $this->evaluate($this->fluxMinWidth);
    }
}
