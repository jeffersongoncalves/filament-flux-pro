<?php

namespace Jeffersongoncalves\FilamentFluxPro;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Jeffersongoncalves\FilamentFlux\FilamentFluxPlugin;
use RuntimeException;

class FilamentFluxProPlugin implements Plugin
{
    protected bool $commandPaletteEnabled = false;

    protected string $commandPaletteShortcut = 'cmd+k';

    protected bool $preferFluxEditor = false;

    protected bool $preferFluxCharts = false;

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(static::getPluginId());

        return $plugin;
    }

    public function getId(): string
    {
        return static::getPluginId();
    }

    public static function getPluginId(): string
    {
        return 'filament-flux-pro';
    }

    public function register(Panel $panel): void
    {
        if (! $panel->hasPlugin(FilamentFluxPlugin::getPluginId())) {
            throw new RuntimeException(
                'FilamentFluxProPlugin requires FilamentFluxPlugin to be registered first. '
                .'Add ->plugin(FilamentFluxPlugin::make()) before FilamentFluxProPlugin::make() in your panel provider.'
            );
        }
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public function enableCommandPalette(bool $enable = true): static
    {
        $this->commandPaletteEnabled = $enable;

        return $this;
    }

    public function commandPaletteShortcut(string $shortcut): static
    {
        $this->commandPaletteShortcut = $shortcut;

        return $this;
    }

    public function preferFluxEditor(bool $prefer = true): static
    {
        $this->preferFluxEditor = $prefer;

        return $this;
    }

    public function preferFluxCharts(bool $prefer = true): static
    {
        $this->preferFluxCharts = $prefer;

        return $this;
    }

    public function isCommandPaletteEnabled(): bool
    {
        return $this->commandPaletteEnabled;
    }

    public function getCommandPaletteShortcut(): string
    {
        return $this->commandPaletteShortcut;
    }

    public function shouldPreferFluxEditor(): bool
    {
        return $this->preferFluxEditor;
    }

    public function shouldPreferFluxCharts(): bool
    {
        return $this->preferFluxCharts;
    }
}
