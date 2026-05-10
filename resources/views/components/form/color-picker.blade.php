@php
    $statePath = $getStatePath();
    $bindKey = $applyStateBindingModifiers('wire:model');

    $bag = new \Illuminate\View\ComponentAttributeBag(array_filter([
        $bindKey => $statePath,
        'format' => $getFluxFormat(),
        'alpha' => $shouldFluxAlpha() ? 'true' : null,
        'inline' => $shouldFluxInline() ? 'true' : null,
        'disabled' => $isDisabled() ? 'true' : null,
        'required' => $isRequired() ? 'true' : null,
        'invalid' => $errors->has($statePath) ? 'true' : null,
        'swatches' => $getFluxSwatches(),
    ], fn ($v) => $v !== null && $v !== ''));
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <x-flux::color-picker :attributes="$bag" />
</x-dynamic-component>
