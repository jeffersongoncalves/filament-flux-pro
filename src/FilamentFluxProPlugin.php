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
use Jeffersongoncalves\FilamentFlux\FilamentFluxPlugin;
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
    ];

    protected bool $commandPaletteEnabled = false;

    protected string $commandPaletteShortcut = 'cmd+k';

    protected bool $preferFluxEditor = false;

    protected bool $preferFluxCharts = false;

    /**
     * Per-field auto-bind toggle. `null` disables the entire feature; an
     * array maps each binding slug (see FIELD_BINDINGS) to a boolean.
     *
     * @var array<string, bool>|null
     */
    protected ?array $useEverywhere = null;

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

    /**
     * Replace Filament Pro Form Fields with their Flux Pro equivalents at
     * the container level. Existing Resources continue to call
     * `DatePicker::make()`, `RichEditor::make()` etc., but receive
     * `FluxDatePicker`/`FluxEditor` instances.
     *
     * @param  bool|array<string, bool>  $config  Pass `true` to enable all
     *                                            bindings, `false` to disable, or a partial array keyed by slug
     *                                            (datePicker, dateTimePicker, timePicker, colorPicker, richEditor,
     *                                            fileUpload, slider, tagsInput).
     */
    public function useEverywhere(bool|array $config = true): static
    {
        if ($config === false) {
            $this->useEverywhere = null;

            return $this;
        }

        $defaults = array_fill_keys(array_keys(static::FIELD_BINDINGS), true);

        if ($config === true) {
            $this->useEverywhere = $defaults;

            return $this;
        }

        $this->useEverywhere = array_merge($defaults, $config);

        return $this;
    }

    /**
     * Slugs of bindings currently active.
     *
     * @return array<int, string>
     */
    public function getActiveBindings(): array
    {
        if ($this->useEverywhere === null) {
            return [];
        }

        return array_keys(array_filter($this->useEverywhere, fn (bool $on): bool => $on));
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

    protected function applyContainerBindings(): void
    {
        if ($this->useEverywhere === null) {
            return;
        }

        foreach ($this->useEverywhere as $slug => $enabled) {
            if (! $enabled) {
                continue;
            }

            $binding = static::FIELD_BINDINGS[$slug] ?? null;

            if ($binding === null) {
                continue;
            }

            app()->bind($binding['from'], $binding['to']);
        }
    }
}
