<?php

namespace Jeffersongoncalves\FilamentFluxPro\Concerns;

use Closure;

trait HasFluxColorFormat
{
    protected string|Closure $fluxFormat = 'hex';

    /**
     * @param  'hex'|'rgb'|'hsl'|Closure  $format
     */
    public function fluxFormat(string|Closure $format): static
    {
        $this->fluxFormat = $format;

        return $this;
    }

    public function getFluxFormat(): string
    {
        $format = $this->evaluate($this->fluxFormat);

        return in_array($format, ['hex', 'rgb', 'hsl'], true) ? $format : 'hex';
    }
}
