<?php

namespace Jeffersongoncalves\FilamentFluxPro\Pages\Concerns;

trait HasCommandPalette
{
    public bool $isCommandPaletteOpen = false;

    public string $commandSearch = '';

    /**
     * @return array<string, array{label: string, icon?: string, shortcut?: string, handler: \Closure}>
     */
    abstract protected function getCommandPaletteCommands(): array;

    public function openCommandPalette(): void
    {
        $this->isCommandPaletteOpen = true;
    }

    public function closeCommandPalette(): void
    {
        $this->isCommandPaletteOpen = false;
        $this->commandSearch = '';
    }

    public function toggleCommandPalette(): void
    {
        $this->isCommandPaletteOpen = ! $this->isCommandPaletteOpen;

        if (! $this->isCommandPaletteOpen) {
            $this->commandSearch = '';
        }
    }

    public function executeCommand(string $key): mixed
    {
        $commands = $this->getCommandPaletteCommands();

        if (! isset($commands[$key])) {
            return null;
        }

        $this->closeCommandPalette();

        return ($commands[$key]['handler'])($this);
    }

    /**
     * @return array<string, array{label: string, icon?: string, shortcut?: string, handler: \Closure}>
     */
    public function getFilteredCommands(): array
    {
        $commands = $this->getCommandPaletteCommands();

        if ($this->commandSearch === '') {
            return $commands;
        }

        $needle = mb_strtolower($this->commandSearch);

        return array_filter(
            $commands,
            fn (array $cmd): bool => str_contains(mb_strtolower($cmd['label']), $needle),
        );
    }
}
