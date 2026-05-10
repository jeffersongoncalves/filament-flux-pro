@php
    $statePath = $getStatePath();
    $bindKey = $applyStateBindingModifiers('wire:model');

    $bag = new \Illuminate\View\ComponentAttributeBag(array_filter([
        $bindKey => $statePath,
        'min' => $getFluxMin(),
        'max' => $getFluxMax(),
        'step' => $getFluxStep(),
        'range' => $isFluxRange() ? 'true' : null,
        'disabled' => $isDisabled() ? 'true' : null,
    ], fn ($v) => $v !== null && $v !== ''));
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <x-flux::slider :attributes="$bag" />
</x-dynamic-component>
