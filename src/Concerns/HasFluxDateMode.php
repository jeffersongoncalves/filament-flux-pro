<?php

namespace Jeffersongoncalves\FilamentFluxPro\Concerns;

use Closure;

trait HasFluxDateMode
{
    protected string|Closure $fluxMode = 'single';

    /**
     * @param  'single'|'range'|'multiple'|Closure  $mode
     */
    public function fluxMode(string|Closure $mode): static
    {
        $this->fluxMode = $mode;

        return $this;
    }

    public function getFluxMode(): string
    {
        $mode = $this->evaluate($this->fluxMode);

        return in_array($mode, ['single', 'range', 'multiple'], true) ? $mode : 'single';
    }
}
