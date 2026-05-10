@php
    $statePath = $getStatePath();
    $bindKey = $applyStateBindingModifiers('wire:model');
    $variant = $getFluxVariant();
    $placeholder = $getFluxPlaceholder();

    $bag = new \Illuminate\View\ComponentAttributeBag(array_filter([
        $bindKey => $statePath,
        'variant' => $variant !== 'default' ? $variant : null,
        'placeholder' => $placeholder,
        'disabled' => $isDisabled() ? 'true' : null,
        'invalid' => $errors->has($statePath) ? 'true' : null,
    ], fn ($v) => $v !== null && $v !== ''));
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <x-flux::composer :attributes="$bag" />
</x-dynamic-component>
