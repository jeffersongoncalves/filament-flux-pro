<?php

namespace Jeffersongoncalves\FilamentFluxPro\Concerns;

use Closure;

trait HasFluxFileUploadConfig
{
    /**
     * @var array<int, string>|Closure|null
     */
    protected array|Closure|null $fluxAccept = null;

    protected bool|Closure $fluxMultiple = false;

    protected int|Closure|null $fluxMaxSize = null;

    protected string|Closure|null $fluxDisk = null;

    protected string|Closure|null $fluxDirectory = null;

    protected string|Closure $fluxVisibility = 'public';

    /**
     * @param  array<int, string>|Closure|null  $accept
     */
    public function fluxAccept(array|Closure|null $accept): static
    {
        $this->fluxAccept = $accept;

        return $this;
    }

    public function fluxMultiple(bool|Closure $multiple = true): static
    {
        $this->fluxMultiple = $multiple;

        return $this;
    }

    public function fluxMaxSize(int|Closure|null $kb): static
    {
        $this->fluxMaxSize = $kb;

        return $this;
    }

    public function fluxDisk(string|Closure|null $disk): static
    {
        $this->fluxDisk = $disk;

        return $this;
    }

    public function fluxDirectory(string|Closure|null $directory): static
    {
        $this->fluxDirectory = $directory;

        return $this;
    }

    public function fluxVisibility(string|Closure $visibility): static
    {
        $this->fluxVisibility = $visibility;

        return $this;
    }

    /**
     * @return array<int, string>|null
     */
    public function getFluxAccept(): ?array
    {
        $accept = $this->evaluate($this->fluxAccept);

        if (blank($accept) || ! is_array($accept)) {
            return null;
        }

        return array_values(array_filter($accept, fn ($a): bool => is_string($a) && $a !== ''));
    }

    public function shouldFluxMultiple(): bool
    {
        return (bool) $this->evaluate($this->fluxMultiple);
    }

    public function getFluxMaxSize(): ?int
    {
        $value = $this->evaluate($this->fluxMaxSize);

        return $value === null ? null : (int) $value;
    }

    public function getFluxDisk(): ?string
    {
        return $this->evaluate($this->fluxDisk);
    }

    public function getFluxDirectory(): ?string
    {
        return $this->evaluate($this->fluxDirectory);
    }

    public function getFluxVisibility(): string
    {
        return (string) $this->evaluate($this->fluxVisibility);
    }
}
