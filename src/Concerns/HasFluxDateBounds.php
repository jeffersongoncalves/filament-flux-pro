<?php

namespace Jeffersongoncalves\FilamentFluxPro\Concerns;

use Carbon\CarbonInterface;
use Closure;
use DateTimeInterface;
use Illuminate\Support\Carbon;

trait HasFluxDateBounds
{
    protected mixed $fluxMin = null;

    protected mixed $fluxMax = null;

    protected mixed $fluxAvailableDates = null;

    protected mixed $fluxUnavailableDates = null;

    public function fluxMin(mixed $min): static
    {
        $this->fluxMin = $min;

        return $this;
    }

    public function fluxMax(mixed $max): static
    {
        $this->fluxMax = $max;

        return $this;
    }

    /**
     * @param  array<int, mixed>|Closure|null  $dates
     */
    public function fluxAvailableDates(array|Closure|null $dates): static
    {
        $this->fluxAvailableDates = $dates;

        return $this;
    }

    /**
     * @param  array<int, mixed>|Closure|null  $dates
     */
    public function fluxUnavailableDates(array|Closure|null $dates): static
    {
        $this->fluxUnavailableDates = $dates;

        return $this;
    }

    public function getFluxMin(): ?string
    {
        return $this->normalizeFluxBound($this->evaluate($this->fluxMin));
    }

    public function getFluxMax(): ?string
    {
        return $this->normalizeFluxBound($this->evaluate($this->fluxMax));
    }

    /**
     * @return array<int, string>|null
     */
    public function getFluxAvailableDates(): ?array
    {
        return $this->normalizeFluxDateList($this->evaluate($this->fluxAvailableDates));
    }

    /**
     * @return array<int, string>|null
     */
    public function getFluxUnavailableDates(): ?array
    {
        return $this->normalizeFluxDateList($this->evaluate($this->fluxUnavailableDates));
    }

    protected function normalizeFluxBound(mixed $value): ?string
    {
        if (blank($value)) {
            return null;
        }

        if ($value instanceof DateTimeInterface) {
            return Carbon::instance($value)->toDateString();
        }

        return Carbon::parse((string) $value)->toDateString();
    }

    /**
     * @return array<int, string>|null
     */
    protected function normalizeFluxDateList(mixed $value): ?array
    {
        if (blank($value) || ! is_array($value)) {
            return null;
        }

        $out = [];
        foreach ($value as $item) {
            if ($item instanceof CarbonInterface || $item instanceof DateTimeInterface) {
                $out[] = Carbon::instance($item)->toDateString();
            } elseif (is_string($item) && $item !== '') {
                $out[] = Carbon::parse($item)->toDateString();
            }
        }

        return $out === [] ? null : $out;
    }
}
