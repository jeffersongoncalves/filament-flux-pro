<?php

namespace Jeffersongoncalves\FilamentFluxPro\Forms\Components;

use Filament\Forms\Components\Field;
use Jeffersongoncalves\FilamentFluxPro\Concerns\HasFluxAutocompleteOptions;

class FluxAutocomplete extends Field
{
    use HasFluxAutocompleteOptions;

    protected string $view = 'filament-flux-pro::components.form.autocomplete';
}
