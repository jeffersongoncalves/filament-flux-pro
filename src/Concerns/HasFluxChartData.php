<?php

namespace Jeffersongoncalves\FilamentFluxPro\Concerns;

use Closure;

trait HasFluxChartData
{
    /**
     * @var array<int, array<string, mixed>>|Closure|null
     */
    protected array|Closure|null $fluxData = null;

    /**
     * @param  array<int, array<string, mixed>>|Closure|null  $data
     */
    public function fluxData(array|Closure|null $data): static
    {
        $this->fluxData = $data;

        return $this;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getFluxData(mixed $record = null): array
    {
        $data = $record !== null
            ? $this->evaluate($this->fluxData, ['record' => $record])
            : $this->evaluate($this->fluxData);

        return is_array($data) ? array_values($data) : [];
    }
}
