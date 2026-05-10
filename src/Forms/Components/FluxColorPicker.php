<?php

namespace Jeffersongoncalves\FilamentFluxPro\Forms\Components;

use Closure;
use Filament\Forms\Components\Field;
use Jeffersongoncalves\FilamentFluxPro\Concerns\HasFluxColorFormat;

class FluxColorPicker extends Field
{
    use HasFluxColorFormat;

    protected string $view = 'filament-flux-pro::components.form.color-picker';

    /**
     * @var array<int, string>|Closure|null
     */
    protected array|Closure|null $fluxSwatches = null;

    protected bool|Closure $fluxAlpha = false;

    protected bool|Closure $fluxInline = false;

    /**
     * @param  array<int, string>|Closure|null  $swatches
     */
    public function fluxSwatches(array|Closure|null $swatches): static
    {
        $this->fluxSwatches = $swatches;

        return $this;
    }

    public function fluxAlpha(bool|Closure $alpha = true): static
    {
        $this->fluxAlpha = $alpha;

        return $this;
    }

    public function fluxInline(bool|Closure $inline = true): static
    {
        $this->fluxInline = $inline;

        return $this;
    }

    /**
     * @return array<int, string>|null
     */
    public function getFluxSwatches(): ?array
    {
        $swatches = $this->evaluate($this->fluxSwatches);

        if (blank($swatches) || ! is_array($swatches)) {
            return null;
        }

        return array_values(array_filter($swatches, fn ($s): bool => is_string($s) && $s !== ''));
    }

    public function shouldFluxAlpha(): bool
    {
        return (bool) $this->evaluate($this->fluxAlpha);
    }

    public function shouldFluxInline(): bool
    {
        return (bool) $this->evaluate($this->fluxInline);
    }
}
