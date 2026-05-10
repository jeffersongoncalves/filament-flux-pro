<?php

namespace Jeffersongoncalves\FilamentFluxPro\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Jeffersongoncalves\FilamentFlux\Support\ThemeFileEditor;

class InstallCommand extends Command
{
    protected $signature = 'filament-flux-pro:install
        {--panel=admin : Panel ID whose theme.css should be patched}
        {--no-publish : Skip vendor:publish steps}';

    protected $description = 'Patch the Filament panel theme.css with Flux Pro @source paths and publish package assets';

    public function handle(ThemeFileEditor $editor): int
    {
        $panel = (string) $this->option('panel');
        $themePath = base_path("resources/css/filament/{$panel}/theme.css");

        $this->components->info("Installing filament-flux-pro into panel [{$panel}]");

        $this->runPreflightChecks();

        if (! File::exists($themePath)) {
            $this->components->error("Theme file not found: {$themePath}");
            $this->components->warn(
                "Run `php artisan make:filament-theme {$panel}` first, then re-run this command."
            );

            return self::FAILURE;
        }

        $sourcesAdded = $editor->addSourceLines($themePath, [
            '../../../../vendor/livewire/flux-pro/dist',
            '../../../../vendor/jeffersongoncalves/filament-flux-pro/resources/views',
        ]);

        if ($sourcesAdded) {
            $this->components->info("Patched {$themePath}");
        } else {
            $this->components->info('theme.css already contains the required @source directives — nothing to do.');
        }

        if (! $this->option('no-publish')) {
            $this->callSilent('vendor:publish', [
                '--tag' => 'filament-flux-pro-config',
                '--force' => false,
            ]);
            $this->components->info('Published config (skipped if already present).');
        }

        $this->newLine();
        $this->components->info('Pré-requisitos no projeto:');
        $this->components->bulletList([
            'composer.json deve ter o repository de https://composer.fluxui.dev',
            'auth.json com credenciais Flux Pro deve existir (e estar no .gitignore)',
            'Rodar `php artisan flux:activate` se ainda não rodou',
        ]);

        $this->newLine();
        $this->components->info('Próximos passos:');
        $this->components->bulletList([
            'Adicionar FilamentFluxProPlugin::make() no panel provider (após FilamentFluxPlugin::make())',
            'Rodar `npm run build` (ou `npm run dev`)',
            'Rodar `php artisan view:clear`',
        ]);

        return self::SUCCESS;
    }

    protected function runPreflightChecks(): void
    {
        $rootComposer = base_path('composer.json');
        if (File::exists($rootComposer)) {
            $contents = (string) File::get($rootComposer);
            if (! str_contains($contents, 'composer.fluxui.dev')) {
                $this->components->warn(
                    'Repository de Flux Pro não encontrado em composer.json. Adicione o repository "composer" apontando para https://composer.fluxui.dev.'
                );
            }
        }

        $authJson = base_path('auth.json');
        if (! File::exists($authJson)) {
            $this->components->warn(
                'auth.json não encontrado. Crie-o na raiz com as credenciais do Flux Pro (NÃO commit) e adicione ao .gitignore.'
            );
        } else {
            $gitignore = base_path('.gitignore');
            if (File::exists($gitignore)) {
                $ignored = (string) File::get($gitignore);
                if (! preg_match('/^auth\.json$/m', $ignored)) {
                    $this->components->error(
                        'ATENÇÃO: auth.json existe mas NÃO está no .gitignore. Risco de commitar credenciais!'
                    );
                }
            }
        }
    }
}
