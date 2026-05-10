@php
    $statePath = $getStatePath();
    $bindKey = $applyStateBindingModifiers('wire:model');

    $bag = new \Illuminate\View\ComponentAttributeBag(array_filter([
        $bindKey => $statePath,
        'mode' => $getFluxMode(),
        'with-time' => $shouldFluxWithTime() ? 'true' : null,
        'min' => $getFluxMin(),
        'max' => $getFluxMax(),
        'locale' => $getFluxLocale() ?? app()->getLocale(),
        'selectable-header' => $shouldFluxSelectableHeader() ? 'true' : null,
        'disabled' => $isDisabled() ? 'true' : null,
        'required' => $isRequired() ? 'true' : null,
        'invalid' => $errors->has($statePath) ? 'true' : null,
        'presets' => $getFluxPresets(),
        'available-dates' => $getFluxAvailableDates(),
        'unavailable-dates' => $getFluxUnavailableDates(),
    ], fn ($v) => $v !== null && $v !== ''));
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <x-flux::date-picker :attributes="$bag" />
</x-dynamic-component>
