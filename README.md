# Filament Flux Pro

Filament v5 plugin that exposes [Livewire Flux Pro](https://fluxui.dev) components — Date Picker, Calendar, Editor, Charts, Kanban, Command Palette and more — as native Filament Form Fields, Widgets and Page Concerns.

> **⚠️ Commercial license required.** This wrapper is MIT-licensed, but it depends on `livewire/flux-pro` which is a paid commercial package by Caleb Porzio. You **must** own a valid Flux Pro license and configure your project's `auth.json` before this plugin will install.

## What this is — and what it isn't

| | `jeffersongoncalves/filament-flux` (free) | `jeffersongoncalves/filament-flux-pro` (this) |
|---|---|---|
| License | MIT | MIT wrapper around proprietary `livewire/flux-pro` |
| Flux package | `livewire/flux` | `livewire/flux-pro` |
| Components | Form fields, atomic UI overrides, navigation shell | Date Picker, Calendar, Editor, Charts, Kanban, Command Palette, Composer (Phases 2–5) |
| Required | — | depends on the free package being registered first |

## Pre-requisites

Before you run `composer require`:

1. **Add the Flux Pro Composer repository** to your project's `composer.json`:

    ```json
    {
        "repositories": [
            { "type": "composer", "url": "https://composer.fluxui.dev" }
        ]
    }
    ```

2. **Create `auth.json`** in your project root with your Flux Pro credentials:

    ```json
    {
        "http-basic": {
            "composer.fluxui.dev": {
                "username": "your-license-email@example.com",
                "password": "your-license-key"
            }
        }
    }
    ```

3. **Add `auth.json` to `.gitignore`** — these credentials authenticate against your paid license. Never commit them.

4. **Register the free plugin first.** This package depends on `jeffersongoncalves/filament-flux` being installed and registered on the panel.

## Installation

```bash
composer require jeffersongoncalves/filament-flux-pro
php artisan filament-flux-pro:install --panel=admin
```

The install command:

- Patches `resources/css/filament/{panel}/theme.css` with the `@source` paths Tailwind v4 needs to scan Flux Pro's stubs and this plugin's views.
- Publishes the config file (`config/filament-flux-pro.php`).
- Warns if any of the pre-requisites above are missing.

After running it:

```bash
php artisan flux:activate     # one-time, if not already done
npm run build
php artisan view:clear
```

## Plugin registration

Register the free plugin **first**, then this one:

```php
use Jeffersongoncalves\FilamentFlux\FilamentFluxPlugin;
use Jeffersongoncalves\FilamentFluxPro\FilamentFluxProPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        // ...
        ->plugin(FilamentFluxPlugin::make())
        ->plugin(
            FilamentFluxProPlugin::make()
                ->enableCommandPalette()
                ->commandPaletteShortcut('cmd+k')
                ->preferFluxEditor()
                ->preferFluxCharts()
        );
}
```

If you forget the free plugin, registration throws a clear `RuntimeException` telling you to add it.

## Configuration

`config/filament-flux-pro.php`:

```php
return [
    'command_palette' => [
        'enabled' => false,
        'shortcut' => 'cmd+k',
    ],
    'editor' => [
        'live_debounce' => 500,
        'image_upload_disk' => 'public',
        'image_upload_path' => 'editor-uploads',
        'sanitize_html' => true,
    ],
    'charts' => [
        'default_height' => 240,
    ],
    'kanban' => [
        'persist_order' => true,
    ],
];
```

## Roadmap

| Phase | Scope |
|---|---|
| **1** | Skeleton, install command, plugin registration, license-aware onboarding (✅ this release) |
| 2 | Date Picker, Calendar, Color Picker form fields |
| 3 | Editor, File Upload, Slider form fields |
| 4 | Charts, Tabs, Accordion (widgets + schema slugs) |
| 5 | Kanban, Command Palette, Composer |
| 6 | Polish, docs, demo |

## License

The wrapper code in this repository is MIT — see [`LICENSE.md`](LICENSE.md). It does **not** grant any rights to `livewire/flux-pro`; you need a separate commercial Flux license from <https://fluxui.dev> to install and run this plugin.
