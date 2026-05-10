<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

beforeEach(function () {
    $this->panel = 'admin';
    $this->themePath = base_path("resources/css/filament/{$this->panel}/theme.css");
    File::ensureDirectoryExists(dirname($this->themePath));
});

afterEach(function () {
    if (File::exists($this->themePath)) {
        File::delete($this->themePath);
    }
});

it('fails when theme.css is missing', function () {
    $exit = Artisan::call('filament-flux-pro:install', [
        '--panel' => $this->panel,
        '--no-publish' => true,
    ]);

    expect($exit)->toBe(1);
    expect(Artisan::output())->toContain('Theme file not found');
});

it('patches theme.css with Flux Pro @source lines', function () {
    File::put($this->themePath, "@import \"tailwindcss\";\n\n@theme {\n}\n");

    $exit = Artisan::call('filament-flux-pro:install', [
        '--panel' => $this->panel,
        '--no-publish' => true,
    ]);

    expect($exit)->toBe(0);

    $contents = File::get($this->themePath);
    expect($contents)
        ->toContain('@source "../../../../vendor/livewire/flux-pro/dist";')
        ->toContain('@source "../../../../vendor/jeffersongoncalves/filament-flux-pro/resources/views";');
});

it('is idempotent — running twice does not duplicate', function () {
    File::put($this->themePath, "@import \"tailwindcss\";\n");

    Artisan::call('filament-flux-pro:install', [
        '--panel' => $this->panel,
        '--no-publish' => true,
    ]);

    Artisan::call('filament-flux-pro:install', [
        '--panel' => $this->panel,
        '--no-publish' => true,
    ]);

    $contents = File::get($this->themePath);
    expect(substr_count($contents, '@source "../../../../vendor/livewire/flux-pro/dist";'))->toBe(1);
    expect(substr_count($contents, '@source "../../../../vendor/jeffersongoncalves/filament-flux-pro/resources/views";'))->toBe(1);
});
