<?php

namespace Jeffersongoncalves\FilamentFluxPro\Forms\Components;

use Closure;

class FluxDateTimePicker extends FluxDatePicker
{
    protected string $view = 'filament-flux-pro::components.form.date-time-picker';

    protected bool|Closure $fluxWithTime = true;
}
