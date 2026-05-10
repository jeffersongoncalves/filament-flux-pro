<?php

namespace Jeffersongoncalves\FilamentFluxPro\Forms\Components;

use Closure;
use Filament\Forms\Components\Field;

class FluxSlider extends Field
{
    protected string $view = 'filament-flux-pro::components.form.slider';

    protected int|float|Closure $fluxMin = 0;

    protected int|float|Closure $fluxMax = 100;

    protected int|float|Closure $fluxStep = 1;

    protected bool|Closure $fluxRange = false;

    protected bool|Closure $fluxShowValue = false;

    public function fluxMin(int|float|Closure $min): static
    {
        $this->fluxMin = $min;

        return $this;
    }

    public function fluxMax(int|float|Closure $max): static
    {
        $this->fluxMax = $max;

        return $this;
    }

    public function fluxStep(int|float|Closure $step): static
    {
        $this->fluxStep = $step;

        return $this;
    }

    public function fluxRange(bool|Closure $range = true): static
    {
        $this->fluxRange = $range;

        return $this;
    }

    public function fluxShowValue(bool|Closure $show = true): static
    {
        $this->fluxShowValue = $show;

        return $this;
    }

    public function getFluxMin(): int|float
    {
        $value = $this->evaluate($this->fluxMin);

        return is_int($value) ? $value : (float) $value;
    }

    public function getFluxMax(): int|float
    {
        $value = $this->evaluate($this->fluxMax);

        return is_int($value) ? $value : (float) $value;
    }

    public function getFluxStep(): int|float
    {
        $value = $this->evaluate($this->fluxStep);

        return is_int($value) ? $value : (float) $value;
    }

    public function isFluxRange(): bool
    {
        return (bool) $this->evaluate($this->fluxRange);
    }

    public function shouldFluxShowValue(): bool
    {
        return (bool) $this->evaluate($this->fluxShowValue);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->dehydrateStateUsing(function ($state) {
            if (blank($state)) {
                return null;
            }

            if ($this->isFluxRange()) {
                if (! is_array($state)) {
                    return null;
                }

                $values = array_values($state);

                return [
                    $this->coerceNumeric($values[0] ?? null),
                    $this->coerceNumeric($values[1] ?? null),
                ];
            }

            return $this->coerceNumeric($state);
        });
    }

    protected function coerceNumeric(mixed $value): int|float|null
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (is_int($value) || is_float($value)) {
            return $value;
        }

        return is_numeric($value) ? $value + 0 : null;
    }
}
