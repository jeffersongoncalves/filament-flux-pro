<?php

namespace Jeffersongoncalves\FilamentFluxPro\Forms\Components;

use Closure;
use Filament\Forms\Components\Field;
use Illuminate\Support\Carbon;
use Jeffersongoncalves\FilamentFluxPro\Concerns\HasFluxDateBounds;
use Jeffersongoncalves\FilamentFluxPro\Concerns\HasFluxDateMode;

class FluxCalendar extends Field
{
    use HasFluxDateBounds;
    use HasFluxDateMode;

    protected string $view = 'filament-flux-pro::components.form.calendar';

    protected string|Closure|null $fluxLocale = null;

    protected int|Closure|null $fluxMonths = null;

    protected bool|Closure $fluxSelectableHeader = true;

    public function fluxLocale(string|Closure|null $locale): static
    {
        $this->fluxLocale = $locale;

        return $this;
    }

    public function fluxMonths(int|Closure|null $months): static
    {
        $this->fluxMonths = $months;

        return $this;
    }

    public function fluxSelectableHeader(bool|Closure $selectable = true): static
    {
        $this->fluxSelectableHeader = $selectable;

        return $this;
    }

    public function getFluxLocale(): ?string
    {
        return $this->evaluate($this->fluxLocale);
    }

    public function getFluxMonths(): ?int
    {
        $value = $this->evaluate($this->fluxMonths);

        return $value === null ? null : (int) $value;
    }

    public function shouldFluxSelectableHeader(): bool
    {
        return (bool) $this->evaluate($this->fluxSelectableHeader);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->dehydrateStateUsing(function ($state) {
            if (blank($state)) {
                return null;
            }

            $mode = $this->getFluxMode();

            if ($mode === 'range' && is_array($state)) {
                $start = $state['start'] ?? $state[0] ?? null;
                $end = $state['end'] ?? $state[1] ?? null;

                return [
                    'start' => $start ? Carbon::parse((string) $start) : null,
                    'end' => $end ? Carbon::parse((string) $end) : null,
                ];
            }

            if ($mode === 'multiple' && is_array($state)) {
                return array_values(array_filter(array_map(
                    fn ($v) => blank($v) ? null : Carbon::parse((string) $v),
                    $state,
                )));
            }

            if ($state instanceof Carbon) {
                return $state;
            }

            return Carbon::parse((string) $state);
        });
    }
}
