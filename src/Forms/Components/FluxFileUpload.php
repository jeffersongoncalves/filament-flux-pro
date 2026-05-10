<?php

namespace Jeffersongoncalves\FilamentFluxPro\Forms\Components;

use Filament\Forms\Components\Field;
use Jeffersongoncalves\FilamentFluxPro\Concerns\HasFluxFileUploadConfig;

class FluxFileUpload extends Field
{
    use HasFluxFileUploadConfig;

    protected string $view = 'filament-flux-pro::components.form.file-upload';

    protected function setUp(): void
    {
        parent::setUp();

        $this->dehydrateStateUsing(function ($state) {
            if (blank($state)) {
                return null;
            }

            if ($this->shouldFluxMultiple() && ! is_array($state)) {
                return [$state];
            }

            return $state;
        });
    }
}
