# Changelog

All notable changes to `filament-flux-pro` will be documented in this file.

## 1.0.0 - 2026-05-10

Initial release. Filament v5 plugin wrapping Livewire Flux Pro 2.x.

### Added

#### Form Fields

- `FluxDatePicker`, `FluxDateTimePicker`, `FluxTimePicker`, `FluxCalendar` — single, range and multiple modes with Carbon-aware dehydration, presets (predefined keys or label-to-tuple maps), min/max bounds, available/unavailable date lists, locale and selectable header.
- `FluxColorPicker` — `hex` / `rgb` / `hsl` formats, swatches, alpha and inline variants.
- `FluxEditor` — rich-text input with toolbar/menu DSL, min/max heights, Flux Pro image upload (`disk`, `directory`, `visibility`, `maxSize`, `accept`) and server-side `HtmlSanitizer` that strips `<script>`, `<style>`, `<iframe>`, inline event handlers and `javascript:` URLs.
- `FluxFileUpload` — `accept`, `multiple`, `maxSize`, `disk`, `directory`, `visibility`.
- `FluxSlider` — single value or dual-handle range mode with numeric coercion.
- `FluxPillbox` — tag input with predefined options, custom values, max cap and clearable.
- `FluxAutocomplete` — synchronous options or asynchronous `fluxOptionsResolver(Closure)` with min-chars and debounce.
- `FluxComposer` — chat-style input with attachments, `@`-mention resolver, placeholder, submit-on-enter and variant.

#### Widgets

- `FluxChartWidget` abstract base with `FluxLineChartWidget`, `FluxAreaChartWidget` and `FluxBarChartWidget` subclasses (heading, description, height, colors, axis/grid/legend toggles).

#### Table columns

- `FluxChartColumn` — sparkline (`line` / `area` / `bar`) inline in table rows with type, color, height, min-width, axis and legend DSL.

#### Schema components

- `FluxTabs` extends Filament's `Tabs` and renders `<flux:tabs>` with `default` / `pills` / `segmented` variants.
- `FluxAccordion` extends Filament's `Section` and renders `<flux:accordion>` with `fluxHeading()`, `fluxIcon()` and `fluxExpanded()`.
- `FluxPopover` static helper that returns an `HtmlString` wrapping trigger + content into `<flux:popover>` with HTML-escaped position.
- `FluxContextMenu` builder-style helper that renders `<flux:context-menu>` with items, separators, danger variants and HTML-escaped labels.

#### Page concerns and abstract pages

- `HasKanban` trait + `FluxKanbanPage` abstract base — `getKanbanColumns()`, `getKanbanModel()`, `getKanbanStatusField()`, `getKanbanData()`, `moveKanbanCard()` updating status + order with an `onKanbanMove()` hook. `KanbanColumnDefinition` configures column id, title, color, title/description fields and a meta closure.
- `HasCommandPalette` trait + `FluxCommandPalettePage` abstract base — `openCommandPalette()`, `closeCommandPalette()`, `toggleCommandPalette()`, `executeCommand($key)` and case-insensitive `getFilteredCommands()`.
- `HasComposer` trait + `FluxComposerPage` abstract base — `composerState`, `submitComposer()` with `onComposerSubmit($state)` hook and `resetComposer()`.

#### Actions

- `FluxCommandAction` extends Filament `Action` with `fluxCommands(array|Closure)` that resolves with the current record so tables and infolists can open record-scoped command palettes.

#### Plugin surface

- `FilamentFluxProPlugin::useEverywhere()` — container-level binding from Filament's native `DatePicker`, `DateTimePicker`, `TimePicker`, `ColorPicker`, `RichEditor`, `FileUpload`, `Slider` and `TagsInput` to their Flux Pro replacements per slug. `enableCommandPalette()`, `commandPaletteShortcut()`, `preferFluxEditor()`, `preferFluxCharts()`.
- `php artisan filament-flux-pro:install --panel=admin` patches `resources/css/filament/{panel}/theme.css` with the `@source` paths Tailwind v4 needs to scan Flux Pro's stubs and this plugin's views, publishes the config, and runs non-blocking pre-flight checks (`composer.json` Flux Pro repository, `auth.json` presence, `auth.json` in `.gitignore`).

#### Support classes

- `EditorImageUploader` — wraps Laravel `Storage` with disk/directory/visibility configuration for `FluxEditor` image uploads.
- `HtmlSanitizer` — server-side sanitizer with a default allowed-tag list covering the standard rich-text surface.
- `KanbanColumnDefinition`, `KanbanCardData`, `CommandRegistry` — fluent value objects used by the kanban and command-palette traits.

### Requirements

- PHP 8.2+
- Filament 5.x
- Laravel 12 or 13
- `livewire/flux-pro` ^2.13 (commercial license required)
- `jeffersongoncalves/filament-flux` ^1.0 registered on the panel before this plugin
