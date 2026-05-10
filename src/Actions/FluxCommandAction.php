<?php

namespace Jeffersongoncalves\FilamentFluxPro\Actions;

use Closure;
use Filament\Actions\Action;

class FluxCommandAction extends Action
{
    /**
     * @var array<string, array{label: string, icon?: string, shortcut?: string, handler: Closure}>|Closure
     */
    protected array|Closure $fluxCommands = [];

    /**
     * @param  array<string, array{label: string, icon?: string, shortcut?: string, handler: Closure}>|Closure  $commands
     */
    public function fluxCommands(array|Closure $commands): static
    {
        $this->fluxCommands = $commands;

        return $this;
    }

    /**
     * @return array<string, array{label: string, icon?: string, shortcut?: string, handler: Closure}>
     */
    public function getFluxCommands(mixed $record = null): array
    {
        $commands = $record !== null
            ? $this->evaluate($this->fluxCommands, ['record' => $record])
            : $this->evaluate($this->fluxCommands);

        return is_array($commands) ? $commands : [];
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->modalSubmitAction(false);
        $this->modalCancelAction(false);
    }
}
