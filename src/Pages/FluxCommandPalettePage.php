<?php

namespace Jeffersongoncalves\FilamentFluxPro\Pages;

use Filament\Pages\Page;
use Jeffersongoncalves\FilamentFluxPro\Pages\Concerns\HasCommandPalette;

abstract class FluxCommandPalettePage extends Page
{
    use HasCommandPalette;
}
