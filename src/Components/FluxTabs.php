<?php

namespace Jeffersongoncalves\FilamentFluxPro\Components;

use Closure;
use Filament\Schemas\Components\Tabs;

class FluxTabs extends Tabs
{
    protected string $view = 'filament-flux-pro::components.tabs';

    protected string|Closure $fluxVariant = 'default';

    public function fluxVariant(string|Closure $variant): static
    {
        $this->fluxVariant = $variant;

        return $this;
    }

    public function getFluxVariant(): string
    {
        return (string) $this->evaluate($this->fluxVariant);
    }
}
