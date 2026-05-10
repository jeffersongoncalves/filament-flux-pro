<?php

namespace Jeffersongoncalves\FilamentFluxPro\Support;

use Closure;

class CommandRegistry
{
    /**
     * @var array<string, array{label: string, icon: ?string, shortcut: ?string, handler: Closure}>
     */
    protected array $commands = [];

    public function add(
        string $key,
        string $label,
        Closure $handler,
        ?string $icon = null,
        ?string $shortcut = null,
    ): static {
        $this->commands[$key] = [
            'label' => $label,
            'icon' => $icon,
            'shortcut' => $shortcut,
            'handler' => $handler,
        ];

        return $this;
    }

    public function remove(string $key): static
    {
        unset($this->commands[$key]);

        return $this;
    }

    public function has(string $key): bool
    {
        return isset($this->commands[$key]);
    }

    /**
     * @return array<string, array{label: string, icon: ?string, shortcut: ?string, handler: Closure}>
     */
    public function all(): array
    {
        return $this->commands;
    }

    /**
     * @return array<string, array{label: string, icon: ?string, shortcut: ?string, handler: Closure}>
     */
    public function search(string $query): array
    {
        if ($query === '') {
            return $this->commands;
        }

        $needle = mb_strtolower($query);

        return array_filter(
            $this->commands,
            fn (array $cmd): bool => str_contains(mb_strtolower($cmd['label']), $needle),
        );
    }

    public function execute(string $key, mixed ...$args): mixed
    {
        if (! isset($this->commands[$key])) {
            return null;
        }

        return ($this->commands[$key]['handler'])(...$args);
    }
}
