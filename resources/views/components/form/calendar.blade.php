@php
    $statePath = $getStatePath();
    $bindKey = $applyStateBindingModifiers('wire:model');

    $bag = new \Illuminate\View\ComponentAttributeBag(array_filter([
        $bindKey => $statePath,
        'mode' => $getFluxMode(),
        'min' => $getFluxMin(),
        'max' => $getFluxMax(),
        'months' => $getFluxMonths(),
        'locale' => $getFluxLocale() ?? app()->getLocale(),
        'selectable-header' => $shouldFluxSelectableHeader() ? 'true' : null,
        'disabled' => $isDisabled() ? 'true' : null,
        'available-dates' => $getFluxAvailableDates(),
        'unavailable-dates' => $getFluxUnavailableDates(),
    ], fn ($v) => $v !== null && $v !== ''));
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <x-flux::calendar :attributes="$bag" />
</x-dynamic-component>
