<?php

namespace Jeffersongoncalves\FilamentFluxPro\Forms\Components;

use Filament\Forms\Components\Field;
use Jeffersongoncalves\FilamentFluxPro\Concerns\HasFluxEditorToolbar;
use Jeffersongoncalves\FilamentFluxPro\Concerns\HasFluxImageUpload;
use Jeffersongoncalves\FilamentFluxPro\Support\HtmlSanitizer;

class FluxEditor extends Field
{
    use HasFluxEditorToolbar;
    use HasFluxImageUpload;

    protected string $view = 'filament-flux-pro::components.form.editor';

    protected ?HtmlSanitizer $sanitizer = null;

    public function sanitizer(?HtmlSanitizer $sanitizer): static
    {
        $this->sanitizer = $sanitizer;

        return $this;
    }

    public function getSanitizer(): HtmlSanitizer
    {
        return $this->sanitizer ??= app(HtmlSanitizer::class);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->dehydrateStateUsing(function ($state) {
            if ($state === null || $state === '') {
                return null;
            }

            if (! is_string($state)) {
                return $state;
            }

            return $this->shouldFluxSanitize()
                ? $this->getSanitizer()->sanitize($state)
                : $state;
        });
    }
}
