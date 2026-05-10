@php
    $statePath = $getStatePath();
    $bindKey = $applyStateBindingModifiers('wire:model');
    $toolbar = $getFluxToolbar();
    $minHeight = $getFluxMinHeight();
    $maxHeight = $getFluxMaxHeight();

    $style = trim(implode(';', array_filter([
        $minHeight ? "min-height: {$minHeight}" : null,
        $maxHeight ? "max-height: {$maxHeight}" : null,
    ])));

    $bag = new \Illuminate\View\ComponentAttributeBag(array_filter([
        $bindKey => $statePath,
        'toolbar' => $toolbar !== null ? implode(' ', $toolbar) : null,
        'style' => $style !== '' ? $style : null,
        'invalid' => $errors->has($statePath) ? 'true' : null,
    ], fn ($v) => $v !== null && $v !== ''));
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <x-flux::editor :attributes="$bag" />
</x-dynamic-component>
