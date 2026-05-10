<?php

namespace Jeffersongoncalves\FilamentFluxPro\Forms\Components;

use Closure;
use Filament\Forms\Components\Field;
use Illuminate\Support\Carbon;

class FluxTimePicker extends Field
{
    protected string $view = 'filament-flux-pro::components.form.time-picker';

    protected int|Closure $fluxStep = 60;

    protected string|Closure|null $fluxMin = null;

    protected string|Closure|null $fluxMax = null;

    public function fluxStep(int|Closure $step): static
    {
        $this->fluxStep = $step;

        return $this;
    }

    public function fluxMin(string|Closure|null $min): static
    {
        $this->fluxMin = $min;

        return $this;
    }

    public function fluxMax(string|Closure|null $max): static
    {
        $this->fluxMax = $max;

        return $this;
    }

    public function getFluxStep(): int
    {
        return (int) $this->evaluate($this->fluxStep);
    }

    public function getFluxMin(): ?string
    {
        return $this->normalizeTime($this->evaluate($this->fluxMin));
    }

    public function getFluxMax(): ?string
    {
        return $this->normalizeTime($this->evaluate($this->fluxMax));
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->dehydrateStateUsing(function ($state) {
            if (blank($state)) {
                return null;
            }

            return $this->normalizeTime($state);
        });
    }

    protected function normalizeTime(mixed $value): ?string
    {
        if (blank($value)) {
            return null;
        }

        if ($value instanceof Carbon) {
            return $value->format('H:i:s');
        }

        $string = (string) $value;

        if (preg_match('/^\d{2}:\d{2}(:\d{2})?$/', $string)) {
            return strlen($string) === 5 ? $string.':00' : $string;
        }

        return Carbon::parse($string)->format('H:i:s');
    }
}
