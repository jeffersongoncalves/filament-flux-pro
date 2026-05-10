<?php

namespace Jeffersongoncalves\FilamentFluxPro\Components;

use Closure;
use Filament\Schemas\Components\Section;

class FluxAccordion extends Section
{
    protected string $view = 'filament-flux-pro::components.accordion';

    protected bool|Closure $fluxExpanded = false;

    public function fluxHeading(string|Closure|null $heading): static
    {
        $this->heading($heading);

        return $this;
    }

    public function fluxIcon(string|Closure|null $icon): static
    {
        $this->icon($icon);

        return $this;
    }

    public function fluxExpanded(bool|Closure $expanded = true): static
    {
        $this->fluxExpanded = $expanded;

        return $this;
    }

    public function isFluxExpanded(): bool
    {
        return (bool) $this->evaluate($this->fluxExpanded);
    }
}
