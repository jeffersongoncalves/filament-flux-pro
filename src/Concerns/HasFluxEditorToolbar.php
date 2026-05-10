<?php

namespace Jeffersongoncalves\FilamentFluxPro\Concerns;

use Closure;

trait HasFluxEditorToolbar
{
    /**
     * @var array<int, string>|Closure|null
     */
    protected array|Closure|null $fluxToolbar = null;

    protected bool|Closure $fluxMenu = false;

    protected string|Closure|null $fluxMinHeight = null;

    protected string|Closure|null $fluxMaxHeight = null;

    protected bool|Closure $fluxSanitize = true;

    /**
     * @param  array<int, string>|Closure|null  $items
     */
    public function fluxToolbar(array|Closure|null $items): static
    {
        $this->fluxToolbar = $items;

        return $this;
    }

    public function fluxMenu(bool|Closure $menu = true): static
    {
        $this->fluxMenu = $menu;

        return $this;
    }

    public function fluxMinHeight(string|Closure|null $height): static
    {
        $this->fluxMinHeight = $height;

        return $this;
    }

    public function fluxMaxHeight(string|Closure|null $height): static
    {
        $this->fluxMaxHeight = $height;

        return $this;
    }

    public function fluxSanitize(bool|Closure $sanitize = true): static
    {
        $this->fluxSanitize = $sanitize;

        return $this;
    }

    /**
     * @return array<int, string>|null
     */
    public function getFluxToolbar(): ?array
    {
        $items = $this->evaluate($this->fluxToolbar);

        if (blank($items) || ! is_array($items)) {
            return null;
        }

        return array_values(array_filter($items, fn ($i): bool => is_string($i) && $i !== ''));
    }

    public function shouldFluxMenu(): bool
    {
        return (bool) $this->evaluate($this->fluxMenu);
    }

    public function getFluxMinHeight(): ?string
    {
        return $this->evaluate($this->fluxMinHeight);
    }

    public function getFluxMaxHeight(): ?string
    {
        return $this->evaluate($this->fluxMaxHeight);
    }

    public function shouldFluxSanitize(): bool
    {
        return (bool) $this->evaluate($this->fluxSanitize);
    }
}
