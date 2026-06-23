<?php

namespace Jeffersongoncalves\FilamentFluxPro;

use Filament\Contracts\Plugin;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Slider;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TimePicker;
use Filament\Panel;
use Filament\Schemas\Components\Tabs;
use Jeffersongoncalves\FilamentFlux\Concerns\ManagesFieldBindings;
use Jeffersongoncalves\FilamentFlux\FilamentFluxPlugin;
use Jeffersongoncalves\FilamentFluxPro\Components\FluxTabs;
use Jeffersongoncalves\FilamentFluxPro\Forms\Components\FluxColorPicker;
use Jeffersongoncalves\FilamentFluxPro\Forms\Components\FluxDatePicker;
use Jeffersongoncalves\FilamentFluxPro\Forms\Components\FluxDateTimePicker;
use Jeffersongoncalves\FilamentFluxPro\Forms\Components\FluxEditor;
use Jeffersongoncalves\FilamentFluxPro\Forms\Components\FluxFileUpload;
use Jeffersongoncalves\FilamentFluxPro\Forms\Components\FluxPillbox;
use Jeffersongoncalves\FilamentFluxPro\Forms\Components\FluxSlider;
use Jeffersongoncalves\FilamentFluxPro\Forms\Components\FluxTimePicker;
use RuntimeException;

class FilamentFluxProPlugin implements Plugin
{
    use ManagesFieldBindings;

    /**
     * Map of every Filament Form Field that the Pro auto-bind supports.
     *
     * Keyed by an arbitrary slug so users can opt-in/out per field with
     * `useEverywhere(['datePicker' => false])`.
     *
     * @var array<string, array{from: class-string, to: class-string}>
     */
    public const FIELD_BINDINGS = [
        'datePicker' => ['from' => DatePicker::class, 'to' => FluxDatePicker::class],
        'dateTimePicker' => ['from' => DateTimePicker::class, 'to' => FluxDateTimePicker::class],
        'timePicker' => ['from' => TimePicker::class, 'to' => FluxTimePicker::class],
        'colorPicker' => ['from' => ColorPicker::class, 'to' => FluxColorPicker::class],
        'richEditor' => ['from' => RichEditor::class, 'to' => FluxEditor::class],
        'fileUpload' => ['from' => FileUpload::class, 'to' => FluxFileUpload::class],
        'slider' => ['from' => Slider::class, 'to' => FluxSlider::class],
        'tagsInput' => ['from' => TagsInput::class, 'to' => FluxPillbox::class],
        'tabs' => ['from' => Tabs::class, 'to' => FluxTabs::class],
    ];

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

        $this->applyContainerBindings();
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
