<?php

namespace Jeffersongoncalves\FilamentFluxPro\Concerns;

use Closure;

trait HasFluxImageUpload
{
    protected string|Closure|null $fluxImageDisk = null;

    protected string|Closure|null $fluxImageDirectory = null;

    protected string|Closure $fluxImageVisibility = 'public';

    protected int|Closure|null $fluxImageMaxSize = null;

    /**
     * @var array<int, string>|Closure|null
     */
    protected array|Closure|null $fluxImageAccept = null;

    /**
     * @param  array<int, string>|Closure|null  $accept
     */
    public function fluxImageUpload(
        string|Closure|null $disk = null,
        string|Closure|null $directory = null,
        string|Closure $visibility = 'public',
        int|Closure|null $maxSize = null,
        array|Closure|null $accept = null,
    ): static {
        $this->fluxImageDisk = $disk;
        $this->fluxImageDirectory = $directory;
        $this->fluxImageVisibility = $visibility;
        $this->fluxImageMaxSize = $maxSize;
        $this->fluxImageAccept = $accept ?? ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];

        return $this;
    }

    public function getFluxImageDisk(): ?string
    {
        return $this->evaluate($this->fluxImageDisk);
    }

    public function getFluxImageDirectory(): ?string
    {
        return $this->evaluate($this->fluxImageDirectory);
    }

    public function getFluxImageVisibility(): string
    {
        return (string) $this->evaluate($this->fluxImageVisibility);
    }

    public function getFluxImageMaxSize(): ?int
    {
        $value = $this->evaluate($this->fluxImageMaxSize);

        return $value === null ? null : (int) $value;
    }

    /**
     * @return array<int, string>|null
     */
    public function getFluxImageAccept(): ?array
    {
        $accept = $this->evaluate($this->fluxImageAccept);

        if (blank($accept) || ! is_array($accept)) {
            return null;
        }

        return array_values(array_filter($accept, fn ($a): bool => is_string($a) && $a !== ''));
    }

    public function isFluxImageUploadEnabled(): bool
    {
        return $this->fluxImageDisk !== null
            || $this->fluxImageDirectory !== null
            || $this->fluxImageAccept !== null
            || $this->fluxImageMaxSize !== null;
    }
}
