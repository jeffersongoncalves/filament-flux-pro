<?php

namespace Jeffersongoncalves\FilamentFluxPro\Concerns;

use Closure;
use DateTimeInterface;
use Illuminate\Support\Carbon;

trait HasFluxDatePresets
{
    /**
     * @var array<mixed>|Closure|null
     */
    protected array|Closure|null $fluxPresets = null;

    /**
     * @param  array<mixed>|Closure|null  $presets
     */
    public function fluxPresets(array|Closure|null $presets): static
    {
        $this->fluxPresets = $presets;

        return $this;
    }

    /**
     * @return array<int|string, mixed>|null
     */
    public function getFluxPresets(): ?array
    {
        $presets = $this->evaluate($this->fluxPresets);

        if (blank($presets) || ! is_array($presets)) {
            return null;
        }

        if (array_is_list($presets)) {
            return array_values(array_filter($presets, fn ($p): bool => is_string($p) && $p !== ''));
        }

        $out = [];
        foreach ($presets as $label => $range) {
            if (! is_array($range) || count($range) !== 2) {
                continue;
            }
            [$start, $end] = array_values($range);
            $out[(string) $label] = [
                $this->presetToDateString($start),
                $this->presetToDateString($end),
            ];
        }

        return $out === [] ? null : $out;
    }

    protected function presetToDateString(mixed $value): ?string
    {
        if (blank($value)) {
            return null;
        }

        if ($value instanceof DateTimeInterface) {
            return Carbon::instance($value)->toDateString();
        }

        return Carbon::parse((string) $value)->toDateString();
    }
}
