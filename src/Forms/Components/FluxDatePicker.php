<?php

namespace Jeffersongoncalves\FilamentFluxPro\Forms\Components;

use Closure;
use Filament\Forms\Components\Field;
use Illuminate\Support\Carbon;
use Jeffersongoncalves\FilamentFluxPro\Concerns\HasFluxDateBounds;
use Jeffersongoncalves\FilamentFluxPro\Concerns\HasFluxDateMode;
use Jeffersongoncalves\FilamentFluxPro\Concerns\HasFluxDatePresets;

class FluxDatePicker extends Field
{
    use HasFluxDateBounds;
    use HasFluxDateMode;
    use HasFluxDatePresets;

    protected string $view = 'filament-flux-pro::components.form.date-picker';

    protected bool|Closure $fluxWithTime = false;

    protected string|Closure|null $fluxLocale = null;

    protected string|Closure|null $fluxDisplayFormat = null;

    protected bool|Closure $fluxSelectableHeader = true;

    public function fluxWithTime(bool|Closure $with = true): static
    {
        $this->fluxWithTime = $with;

        return $this;
    }

    public function fluxLocale(string|Closure|null $locale): static
    {
        $this->fluxLocale = $locale;

        return $this;
    }

    public function fluxDisplayFormat(string|Closure|null $format): static
    {
        $this->fluxDisplayFormat = $format;

        return $this;
    }

    public function fluxSelectableHeader(bool|Closure $selectable = true): static
    {
        $this->fluxSelectableHeader = $selectable;

        return $this;
    }

    public function shouldFluxWithTime(): bool
    {
        return (bool) $this->evaluate($this->fluxWithTime);
    }

    public function getFluxLocale(): ?string
    {
        return $this->evaluate($this->fluxLocale);
    }

    public function getFluxDisplayFormat(): ?string
    {
        return $this->evaluate($this->fluxDisplayFormat);
    }

    public function shouldFluxSelectableHeader(): bool
    {
        return (bool) $this->evaluate($this->fluxSelectableHeader);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->dehydrateStateUsing(function ($state) {
            return $this->dehydrateFluxDateState($state);
        });

        $this->formatStateUsing(function ($state) {
            return $this->formatFluxDateState($state);
        });
    }

    protected function dehydrateFluxDateState(mixed $state): mixed
    {
        if (blank($state)) {
            return null;
        }

        $mode = $this->getFluxMode();

        if ($mode === 'range') {
            if (is_array($state)) {
                $start = $state['start'] ?? $state[0] ?? null;
                $end = $state['end'] ?? $state[1] ?? null;

                return [
                    'start' => $start ? Carbon::parse((string) $start) : null,
                    'end' => $end ? Carbon::parse((string) $end) : null,
                ];
            }

            return null;
        }

        if ($mode === 'multiple') {
            if (! is_array($state)) {
                return null;
            }

            return array_values(array_filter(array_map(
                fn ($v) => blank($v) ? null : Carbon::parse((string) $v),
                $state,
            )));
        }

        if ($state instanceof Carbon) {
            return $state;
        }

        return Carbon::parse((string) $state);
    }

    protected function formatFluxDateState(mixed $state): mixed
    {
        if (blank($state)) {
            return null;
        }

        $mode = $this->getFluxMode();
        $withTime = $this->shouldFluxWithTime();

        if ($mode === 'range' && is_array($state)) {
            $start = $state['start'] ?? $state[0] ?? null;
            $end = $state['end'] ?? $state[1] ?? null;

            return [
                'start' => $this->formatSingle($start, $withTime),
                'end' => $this->formatSingle($end, $withTime),
            ];
        }

        if ($mode === 'multiple' && is_array($state)) {
            return array_values(array_filter(array_map(
                fn ($v) => $this->formatSingle($v, $withTime),
                $state,
            )));
        }

        return $this->formatSingle($state, $withTime);
    }

    protected function formatSingle(mixed $value, bool $withTime): ?string
    {
        if (blank($value)) {
            return null;
        }

        if (! $value instanceof Carbon) {
            $value = Carbon::parse((string) $value);
        }

        return $withTime ? $value->format('Y-m-d H:i:s') : $value->toDateString();
    }
}
