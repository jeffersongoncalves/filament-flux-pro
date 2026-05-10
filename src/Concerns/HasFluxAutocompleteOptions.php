<?php

namespace Jeffersongoncalves\FilamentFluxPro\Concerns;

use Closure;

trait HasFluxAutocompleteOptions
{
    protected ?Closure $fluxOptionsResolver = null;

    /**
     * @var array<string|int, string>|Closure|null
     */
    protected array|Closure|null $fluxOptions = null;

    protected bool|Closure $fluxSearchable = true;

    protected int|Closure $fluxMinChars = 0;

    protected int|Closure $fluxDebounce = 300;

    /**
     * @param  array<string|int, string>|Closure|null  $options
     */
    public function options(array|Closure|null $options): static
    {
        $this->fluxOptions = $options;

        return $this;
    }

    public function fluxOptionsResolver(?Closure $resolver): static
    {
        $this->fluxOptionsResolver = $resolver;

        return $this;
    }

    public function fluxSearchable(bool|Closure $searchable = true): static
    {
        $this->fluxSearchable = $searchable;

        return $this;
    }

    public function fluxMinChars(int|Closure $min): static
    {
        $this->fluxMinChars = $min;

        return $this;
    }

    public function fluxDebounce(int|Closure $ms): static
    {
        $this->fluxDebounce = $ms;

        return $this;
    }

    /**
     * @return array<string|int, string>
     */
    public function getFluxOptions(string $search = ''): array
    {
        if ($this->fluxOptionsResolver !== null && $search !== '') {
            $resolved = $this->evaluate($this->fluxOptionsResolver, ['search' => $search]);

            return is_array($resolved) ? $resolved : [];
        }

        $options = $this->evaluate($this->fluxOptions);

        return is_array($options) ? $options : [];
    }

    public function shouldFluxSearchable(): bool
    {
        return (bool) $this->evaluate($this->fluxSearchable);
    }

    public function getFluxMinChars(): int
    {
        return (int) $this->evaluate($this->fluxMinChars);
    }

    public function getFluxDebounce(): int
    {
        return (int) $this->evaluate($this->fluxDebounce);
    }

    public function hasFluxOptionsResolver(): bool
    {
        return $this->fluxOptionsResolver !== null;
    }
}
