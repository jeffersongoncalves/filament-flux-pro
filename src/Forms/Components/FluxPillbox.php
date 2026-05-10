<?php

namespace Jeffersongoncalves\FilamentFluxPro\Forms\Components;

use Closure;
use Filament\Forms\Components\Field;
use Illuminate\Support\Collection;

class FluxPillbox extends Field
{
    protected string $view = 'filament-flux-pro::components.form.pillbox';

    /**
     * @var array<string|int, string>|Closure|null
     */
    protected array|Closure|null $fluxOptions = null;

    protected bool|Closure $fluxAllowCustom = false;

    protected int|Closure|null $fluxMax = null;

    protected bool|Closure $fluxClearable = false;

    protected string|Closure $fluxVariant = 'combobox';

    /**
     * @param  array<string|int, string>|Closure|null  $options
     */
    public function options(array|Closure|null $options): static
    {
        $this->fluxOptions = $options;

        return $this;
    }

    public function fluxAllowCustom(bool|Closure $allow = true): static
    {
        $this->fluxAllowCustom = $allow;

        return $this;
    }

    public function fluxMax(int|Closure|null $max): static
    {
        $this->fluxMax = $max;

        return $this;
    }

    public function fluxClearable(bool|Closure $clearable = true): static
    {
        $this->fluxClearable = $clearable;

        return $this;
    }

    public function fluxVariant(string|Closure $variant): static
    {
        $this->fluxVariant = $variant;

        return $this;
    }

    /**
     * @return array<string|int, string>
     */
    public function getFluxOptions(): array
    {
        $options = $this->evaluate($this->fluxOptions);

        if ($options instanceof Collection) {
            return $options->all();
        }

        return is_array($options) ? $options : [];
    }

    public function isFluxAllowCustom(): bool
    {
        return (bool) $this->evaluate($this->fluxAllowCustom);
    }

    public function getFluxMax(): ?int
    {
        $value = $this->evaluate($this->fluxMax);

        return $value === null ? null : (int) $value;
    }

    public function isFluxClearable(): bool
    {
        return (bool) $this->evaluate($this->fluxClearable);
    }

    public function getFluxVariant(): string
    {
        return (string) $this->evaluate($this->fluxVariant);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->dehydrateStateUsing(function ($state) {
            if (blank($state)) {
                return [];
            }

            if (! is_array($state)) {
                return [$state];
            }

            $values = array_values(array_filter(
                $state,
                fn ($v): bool => $v !== null && $v !== '',
            ));

            $max = $this->getFluxMax();

            return $max !== null ? array_slice($values, 0, $max) : $values;
        });
    }
}
